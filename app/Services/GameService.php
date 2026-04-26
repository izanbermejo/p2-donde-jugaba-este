<?php

namespace App\Services;

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
        $intentos = 0;

        do {
            $intentos++;

            // 1. elegir países y clubes aleatorios por dificultad
            $paises = Pais::where('dificultad_pais', $dificultad)
                ->inRandomOrder()
                ->take(3)
                ->pluck('id_pais')
                ->toArray();

            $clubes = Club::where('dificultad_club', $dificultad)
                ->inRandomOrder()
                ->take(3)
                ->pluck('id_club')
                ->toArray();

            // 2. validar que exista al menos 1 jugador por combinación país-club
            $valido = true;

            foreach ($paises as $pais) {

                $existe = Jugador::where('pais_jugador', $pais)
                    ->whereHas('clubes', function ($q) use ($clubes) {
                        $q->whereIn('clubes.id_club', $clubes);
                    })
                    ->exists();

                if (!$existe) {
                    $valido = false;
                    break;
                }
            }

            $valido = true;

            foreach ($paises as $pais) {

                $existe = Jugador::where('pais_jugador', $pais)
                    ->whereHas('clubes', function ($q) use ($clubes) {
                        $q->whereIn('clubes.id_club', $clubes);
                    })
                    ->exists();

                if (!$existe) {
                    $valido = false;
                    break;
                }
            }

            // si es válido, salimos del bucle
        } while (!$valido && $intentos < 10);

        // 3. si después de varios intentos no hay combinación válida
        if (!$valido) {
            return [
                'ok' => false,
                'message' => 'No se pudo generar una partida válida'
            ];
        }

        // 4. crear partida
        $partida = Partida::create([
            'id_usuario' => $id_usuario,
            'id_juego' => $id_juego,
            'id_dificultad' => $dificultad,
            'estado' => [
                'paises' => $paises,
                'clubes' => $clubes,
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
    $estado['tablero'][$key] = $jugador;

    $partida->puntuacion += 100;
    $partida->estado = $estado;
    $partida->save();

    return [
        'ok' => true,
        'jugador' => $jugador
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

        $this->rankingService->actualizarMejorRegistro($partida);

        return [
            'ok' => true,
            'puntuacion' => $puntuacionFinal,
            'segundos' => $segundos,
            'completo' => $completo
        ];
    }
}