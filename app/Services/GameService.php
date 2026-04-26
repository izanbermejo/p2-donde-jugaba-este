<?php

namespace App\Services;

use App\Http\Controllers\RankingController;
use App\Models\Partida;
use App\Models\Jugador;
use App\Models\Pais;
use App\Models\Club;
use App\Models\Ranking;
use Carbon\Carbon;

class GameService
{
    // INICIAR PARTIDA
    public function iniciarPartida($id_usuario, $id_juego, $dificultad)
{
    // 1. obtener combinaciones reales (pais + club)
    $combinaciones = \DB::table('jugadores')
    ->join('jugador_has_club', 'jugadores.id_jugador', '=', 'jugador_has_club.id_jugador')
    ->join('paises', 'paises.id_pais', '=', 'jugadores.pais_jugador')
    ->join('clubes', 'clubes.id_club', '=', 'jugador_has_club.id_club')
    ->where('paises.dificultad_pais', $dificultad)
    ->where('clubes.dificultad_club', $dificultad)
    ->select(
        'jugadores.pais_jugador as pais',
        'jugador_has_club.id_club as club'
    )
    ->distinct()
    ->get();

    // 2. construir mapa pais => clubes
    $mapa = [];

    foreach ($combinaciones as $c) {
        $mapa[$c->pais][] = $c->club;
    }

    // 3. buscar 3 países con al menos 3 clubes en común
    $paisesKeys = array_keys($mapa);
    shuffle($paisesKeys);

    $paisesSeleccionados = [];
    $clubesSeleccionados = [];

    foreach ($paisesKeys as $p1) {
        foreach ($paisesKeys as $p2) {
            foreach ($paisesKeys as $p3) {

                if ($p1 == $p2 || $p1 == $p3 || $p2 == $p3) continue;

                $interseccion = array_intersect(
                    $mapa[$p1],
                    $mapa[$p2],
                    $mapa[$p3]
                );

                if (count($interseccion) >= 3) {
                    $paisesSeleccionados = [$p1, $p2, $p3];
                    $clubesSeleccionados = array_slice($interseccion, 0, 3);
                    break 3;
                }
            }
        }
    }

    // 4. si no hay combinación válida
    if (empty($paisesSeleccionados) || empty($clubesSeleccionados)) {
        return [
            'ok' => false,
            'message' => 'No hay combinaciones suficientes en la base de datos'
        ];
    }

    // 5. crear partida
    $partida = Partida::create([
        'id_usuario' => $id_usuario,
        'id_juego' => $id_juego,
        'id_dificultad' => $dificultad,
        'estado' => [
            'paises' => $paisesSeleccionados,
            'clubes' => $clubesSeleccionados,
            'tablero' => []
        ],
        'puntuacion' => 0,
        'inicio' => now()
    ]);

    return [
        'ok' => true,
        'partida' => $partida
    ];
}

    public function jugar($id_partida, $fila, $columna, $id_jugador = null)
{
    $partida = Partida::findOrFail($id_partida);
    $estado = $partida->estado;

    $key = "{$fila}-{$columna}";

    // 1. casilla ocupada
    if (isset($estado['tablero'][$key])) {
        return [
            'ok' => false,
            'message' => 'Esta casilla ya está ocupada'
        ];
    }

    // 2. restricciones
    $id_pais = $estado['paises'][$columna - 1] ?? null;
    $id_club = $estado['clubes'][$fila - 1] ?? null;

    if (!$id_pais || !$id_club) {
        return [
            'ok' => false,
            'message' => 'Casilla inválida'
        ];
    }

    // 3. obligatorio seleccionar jugador
    if (!$id_jugador) {
        return [
            'ok' => false,
            'message' => 'Debes seleccionar un jugador'
        ];
    }

    // 4. buscar jugador
    $jugador = Jugador::with('clubes')->find($id_jugador);

    if (!$jugador) {
        return [
            'ok' => false,
            'message' => 'Jugador no encontrado'
        ];
    }

    // 5. validar país
    if ($jugador->pais_jugador != $id_pais) {
        return [
            'ok' => false,
            'message' => 'El jugador no es de ese país'
        ];
    }

    // 6. validar club (pivote 🔥)
    $haJugado = $jugador->clubes()
        ->where('clubes.id_club', $id_club)
        ->exists();

    if (!$haJugado) {
        return [
            'ok' => false,
            'message' => 'El jugador nunca ha jugado en ese club'
        ];
    }

    // 7. guardar
    $estado['tablero'][$key] = $id_jugador;

    $partida->puntuacion += 100;
    $partida->estado = $estado;
    $partida->save();

    if (count($partida->estado['tablero'] ?? []) === 9) {

    $resultado = $this->finalizarPartida($id_partida);

    return [
        'ok' => true,
        'jugador' => $jugador,
        'victoria' => true,
        'puntuacion_final' => $resultado['puntuacion']
    ];
    }

    return [
        'ok' => true,
        'jugador' => $jugador
    ];
}

    public function rendirse($id_partida)
{
    $partida = Partida::findOrFail($id_partida);

    $partida->fin = now();
    $partida->save();

    $puntuacionFinal = $partida->puntuacion;

    try {
        app(\App\Http\Controllers\Api\RankingController::class)
            ->actualizarMejorRegistro($partida);
    } catch (\Throwable $e) {
        \Log::error('ERROR RANKING: ' . $e->getMessage());
    }

    return [
        'ok' => true,
        'mensaje' => 'Te has rendido',
        'puntuacion' => $puntuacionFinal
    ];
}

    public function finalizarPartida($id_partida)
    {
        $partida = Partida::findOrFail($id_partida);

        $inicio = Carbon::parse($partida->inicio);
        $fin = Carbon::now();

        $segundos = $inicio->diffInSeconds($fin);

        $partida->fin = $fin;

        // 1. comprobar si tablero está completo (3x3 = 9 casillas)
        $tablero = $partida->estado['tablero'] ?? [];
        $completo = count($tablero) === 9;

        // 2. puntuación base
        $puntuacion = $partida->puntuacion;

        // 3. bonus por dificultad
        switch ($partida->id_dificultad) {
            case 1:
                $puntuacion += 0;
                break;
            case 2:
                $puntuacion += 200;
                break;
            case 3:
                $puntuacion += 500;
                break;
        }

        // 4. multiplicador por tiempo
        $multiplicador = 1.0;

        if ($segundos <= 60) {
            $multiplicador = 1.50;
        } elseif ($segundos <= 90) {
            $multiplicador = 1.35;
        } elseif ($segundos <= 120) {
            $multiplicador = 1.20;
        } elseif ($segundos <= 180) {
            $multiplicador = 1.10;
        }

        $puntuacionFinal = (int) round($puntuacion * $multiplicador);

        $partida->puntuacion = $puntuacionFinal;
        $partida->save();

        // 5. actualizar ranking

        try {
            app(\App\Http\Controllers\Api\RankingController::class)
                ->actualizarMejorRegistro($partida);
        } catch (\Throwable $e) {
            \Log::error('ERROR RANKING: ' . $e->getMessage());
        }

        return [
            'ok' => true,
            'puntuacion' => $puntuacionFinal,
            'segundos' => $segundos,
            'completo' => $completo
        ];
    }
}