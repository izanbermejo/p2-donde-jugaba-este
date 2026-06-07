<?php

namespace App\Services;

use App\Models\Partida;
use App\Models\Jugador;

class Path4Service
{
    public function iniciarPartida($id_usuario, $id_juego, $dificultad)
    {
        $dificultadString = (string) $dificultad;

        // Buscar un jugador que tenga al menos 4 clubes
        $jugador = \DB::table('jugadores')
            ->join('paises', 'paises.id_pais', '=', 'jugadores.pais_jugador')
            ->join('jugador_has_club', 'jugador_has_club.id_jugador', '=', 'jugadores.id_jugador')
            ->where('paises.dificultad_pais', $dificultadString)
            ->groupBy('jugadores.id_jugador')
            ->havingRaw('COUNT(jugador_has_club.id_club) >= 4')
            ->inRandomOrder()
            ->select('jugadores.id_jugador')
            ->first();

        if (!$jugador) {
            return [
                'ok' => false,
                'message' => 'No se encontró ningún jugador válido'
            ];
        }

        // Obtener todos los clubes del jugador
        $clubes = \DB::table('jugador_has_club')
            ->where('id_jugador', $jugador->id_jugador)
            ->pluck('id_club')
            ->toArray();

        // Elegir 4 clubes aleatorios
        shuffle($clubes);

        $clubesSeleccionados = array_slice($clubes, 0, 4);

        // Crear partida
        $partida = Partida::create([
            'id_usuario' => $id_usuario,
            'id_juego' => $id_juego,
            'id_dificultad' => $dificultad,
            'estado' => [
                'jugador_objetivo' => $jugador->id_jugador,
                'clubes' => $clubesSeleccionados,
                'clubes_revelados' => 1
            ],
            'puntuacion' => 0,
            'inicio' => now()
        ]);

        return [
            'ok' => true,
            'partida' => $partida
        ];
    }


    public function jugar($id_partida, $id_jugador)
    {
        $partida = Partida::findOrFail($id_partida);

        $estado = $partida->estado;

        $correcto = ($id_jugador == $estado['jugador_objetivo']);

        $victoria = false;
        $revelarClub = null;

        if ($correcto) {
            $victoria = true;
        } else {

            $index = $estado['clubes_revelados'];

            $revelarClub = $estado['clubes'][$index] ?? null;

            $estado['clubes_revelados']++;
        }

        $partida->estado = $estado;
        $partida->save();

        return [
            'ok' => true,
            'correcto' => $correcto,
            'victoria' => $victoria,
            'revelar_club' => $revelarClub,
            'clubes_revelados' => $estado['clubes_revelados'],
        ];
    }
}