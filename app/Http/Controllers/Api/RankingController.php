<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRankingRequest;
use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function indexTotalUsuario(){
        $ranking_global = Ranking::select('id_usuario')
            ->selectRaw('SUM(puntuacion) as total_puntuacion')
            ->groupBy('id_usuario')
            ->get();
        return $ranking_global;
    }

    public function indexByIdJuego($id_juego){
        $ranking_juego = Ranking::where('id_juego', $id_juego)->get();
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
