<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ranking;

class RankingController extends Controller
{
    public function indexGlobal(){
        $ranking_global = Ranking::join('users', 'rankings.id_usuario', '=', 'users.id')
            ->select(
                'rankings.id_usuario',
                'users.name'
            )
            ->selectRaw('SUM(puntuacion) as total_puntuacion')
            ->groupBy('id_usuario', 'name')
            ->orderByDesc('total_puntuacion')
            ->get();
        return $ranking_global;
    }

    public function indexByIdJuego($id_juego){
        $ranking_juego = Ranking::join('users', 'rankings.id_usuario', '=', 'users.id')
            ->where('rankings.id_juego', $id_juego)
            ->select(
                'rankings.id_usuario',
                'users.name',
                'rankings.fecha',
                'rankings.puntuacion',
            )
            ->orderByDesc('rankings.puntuacion')
            ->get();

        return $ranking_juego;
    }

    public function actualizarMejorRegistro($partida){
        $record_actual = Ranking::where('id_usuario', $partida->id_usuario)
                                ->where('id_juego', $partida->id_juego)
                                ->first();

        Ranking::updateOrCreate(
            [
                'id_usuario' => $partida->id_usuario,
                'id_juego' => $partida->id_juego,
            ],
            [
                'id_partida' => $partida->id_partida,
                'id_dificultad' => $partida->id_dificultad,
                'puntuacion' => max($partida->puntuacion, optional($record_actual)->puntuacion ?? 0),
                'inicio' => $partida->inicio,
                'fin' => $partida->fin,
            ]
        );
    }
}
