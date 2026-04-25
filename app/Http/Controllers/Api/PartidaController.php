<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GameService;

class PartidaController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * 🟢 INICIAR PARTIDA
     */
    public function iniciar(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_juego' => 'required|integer',
            'id_dificultad' => 'required|integer',
        ]);

        return response()->json(
            $this->gameService->iniciarPartida(
                $request->id_usuario,
                $request->id_juego,
                $request->id_dificultad
            )
        );
    }

    /**
     * 🟡 JUGAR CASILLA
     */
    public function jugar(Request $request)
    {
        $request->validate([
            'id_partida' => 'required|integer',
            'fila' => 'required|integer',
            'columna' => 'required|integer',
            'id_jugador' => 'nullable|integer'
        ]);

        return response()->json(
            $this->gameService->jugar(
                $request->id_partida,
                $request->fila,
                $request->columna,
                $request->id_jugador
            )
        );
    }

    /**
     * 🔴 FINALIZAR PARTIDA
     */
    public function finalizar(Request $request)
    {
        $request->validate([
            'id_partida' => 'required|integer',
        ]);

        return response()->json(
            $this->gameService->finalizarPartida(
                $request->id_partida
            )
        );
    }
}