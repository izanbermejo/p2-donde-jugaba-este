<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJugadorRequest;
use App\Http\Requests\UpdateJugadorRequest;
use App\Models\Jugador;

class JugadorController extends Controller
{
    public function index(){
        $jugadores = Jugador::all();
        return $jugadores;
    }

    public function show($id_jugador){
        $jugador = Jugador::find($id_jugador);
        return $jugador;
    }

    public function destroy($id_jugador){
        $jugador = Jugador::find($id_jugador);
        $jugador->delete();

        return response()->json([
            'message' => 'Jugador eliminado correctamente',
            'data' => $jugador
        ]);
    }

    public function store(StoreJugadorRequest $request){
        $data = $request->validated();
        $jugador = Jugador::create($data);
        return $jugador;
    }

    public function update(UpdateJugadorRequest $request, $id_jugador){
        
        $jugador = Jugador::find($id_jugador);
        $jugador->update($request->validated());


        return response()->json([
            'message' => 'Jugador actualizado correctamente',
            'data' => $jugador->fresh()
        ]);
    }
}
