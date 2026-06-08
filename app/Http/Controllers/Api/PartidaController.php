<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GameService;
use App\Services\Path4Service;

class PartidaController extends Controller
{

    protected $gameService;
    protected $path4Service;

    public function __construct(GameService $gameService, Path4Service $path4Service)
    {
        $this->gameService = $gameService;
        $this->path4Service = $path4Service;
    }
        
    /*
    *           *
    **         **
    *** MATCH9 ***
    **         **
    *           *
    */
    // INICIAR PARTIDA
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

    // JUGAR CASILLA
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

    public function rendirse(Request $request)
    {
        $request->validate([
            'id_partida' => 'required|integer',
        ]);

        return response()->json(
            $this->gameService->rendirse($request->id_partida)
        );
    }

    // FINALIZAR PARTIDA
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


    /*
    *           *
    **         **
    *** PATH4 ***
    **         **
    *           *
    */
    public function iniciarPath4(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_juego' => 'required|integer',
            'id_dificultad' => 'required|integer',
        ]);

        return response()->json(
            $this->path4Service->iniciarPartida(
                $request->id_usuario,
                $request->id_juego,
                $request->id_dificultad
            )
        );
    }
    public function jugarPath4(Request $request)
    {
        $request->validate([
            'id_partida' => 'required|integer',
            'id_jugador' => 'required|integer'
        ]);

        return response()->json(
            $this->path4Service->jugar(
                $request->id_partida,
                $request->id_jugador
            )
        );
    }
}