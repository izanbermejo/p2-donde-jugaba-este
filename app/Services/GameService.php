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
    public function iniciarPartida($usuarioId, $juegoId, $dificultad)
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
            'id_usuario' => $usuarioId,
            'id_juego' => $juegoId,
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

    public function jugar($partidaId, $fila, $columna, $jugadorId = null)
    {
        $partida = Partida::findOrFail($partidaId);
        $estado = $partida->estado;

        $key = "{$fila}-{$columna}";

        // 1. comprobar si ya está ocupada
        if (isset($estado['tablero'][$key])) {
            return [
                'ok' => false,
                'message' => 'Esta casilla ya está ocupada'
            ];
        }

        // 2. obtener restricciones de la casilla
        $paisId = $estado['paises'][$fila - 1] ?? null;
        $clubId = $estado['clubes'][$columna - 1] ?? null;

        if (!$paisId || !$clubId) {
            return [
                'ok' => false,
                'message' => 'Casilla inválida'
            ];
        }

        // 3. buscar jugadores válidos
        $query = Jugador::where('pais_jugador', $paisId)
        ->whereHas('clubes', function ($q) use ($clubId) {
            $q->where('clubes.id_club', $clubId);
        });

        // si el usuario ya seleccionó uno concreto
        if ($jugadorId) {
            $jugador = $query->where('id_jugador', $jugadorId)->first();

            if (!$jugador) {
                return [
                    'ok' => false,
                    'message' => 'Jugador incorrecto para esta casilla'
                ];
            }

            $estado['tablero'][$key] = $jugador->id_jugador;
            $partida->puntuacion += 100;
            $partida->estado = $estado;
            $partida->save();

            return [
                'ok' => true,
                'message' => 'Correcto',
                'jugador' => $jugador
            ];
        }

        // 4. si no se pasa jugador → buscamos candidatos
        $jugadores = $query->get();

        if ($jugadores->isEmpty()) {
            return [
                'ok' => false,
                'message' => 'No hay jugadores para esta casilla'
            ];
        }

        // 5. si solo hay 1 → auto colocar
        if ($jugadores->count() === 1) {
            $jugador = $jugadores->first();

            $estado['tablero'][$key] = $jugador->id_jugador;
            $partida->puntuacion += 100;

            $partida->estado = $estado;
            $partida->save();

            return [
                'ok' => true,
                'auto' => true,
                'jugador' => $jugador
            ];
        }

        // 6. si hay varios → devolver opciones
        return [
            'ok' => true,
            'multiple' => true,
            'jugadores' => $jugadores
        ];
    }

    public function finalizarPartida($partidaId)
    {
        $partida = Partida::findOrFail($partidaId);

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
        $this->actualizarRanking(
            $partida->id_usuario,
            $partida->id_juego,
            $puntuacionFinal
        );

        return [
            'ok' => true,
            'puntuacion' => $puntuacionFinal,
            'segundos' => $segundos,
            'completo' => $completo
        ];
    }

    private function actualizarRanking($usuarioId, $juegoId, $puntos)
    {
        $ranking = Ranking::firstOrNew([
            'id_usuario' => $usuarioId,
            'id_juego' => $juegoId
        ]);

        if (!$ranking->exists || $puntos > $ranking->puntuacion) {
            $ranking->puntuacion = $puntos;
            $ranking->save();
        }
    }
}