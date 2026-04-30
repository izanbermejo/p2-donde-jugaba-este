<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJugadorRequest;
use App\Http\Requests\UpdateJugadorRequest;
use App\Models\Jugador;
use Illuminate\Support\Facades\DB;

class JugadorController extends Controller
{
    // Devuelve una lista paginada de jugadores con su país asociado
    public function index(Request $request){
        $perPage = $request->input('rows', 10);
        $page = $request->input('page', 1);

        $jugadores = Jugador::with('pais')->paginate($perPage);

        return response()->json($jugadores);
    }

    // Devuelve los datos de un jugador por su ID
    public function show($id_jugador){
        $jugador = Jugador::find($id_jugador);
        return $jugador;
    }

    // Elimina un jugador por su ID
    public function destroy($id_jugador){
        $jugador = Jugador::find($id_jugador);
        $jugador->delete();

        return response()->json([
            'message' => 'Jugador eliminado correctamente',
            'data' => $jugador
        ]);
    }

    // Crea un nuevo jugador validando los datos de entrada
    public function store(StoreJugadorRequest $request){
        $data = $request->validated();
        $jugador = Jugador::create($data);
        return $jugador;
    }

    // Actualiza los datos de un jugador existente
    public function update(UpdateJugadorRequest $request, $id_jugador){
        $jugador = Jugador::find($id_jugador);
        $jugador->update($request->validated());

        return response()->json([
            'message' => 'Jugador actualizado correctamente',
            'data' => $jugador->fresh()
        ]);
    }

    // Devuelve jugadores filtrados por país
    public function indexByIdPais($id_pais){
        $jugadores = Jugador::where('pais_jugador', $id_pais)->get();
        return $jugadores;
    }

    // Devuelve jugadores filtrados por posición
    public function indexByIdPosicion($id_posicion){
        $jugadores = Jugador::where('posicion_jugador', $id_posicion)->get();
        return $jugadores;
    }

    // Devuelve los clubes asociados a un jugador
    public function getClubes($id)
    {
        $jugador = Jugador::with('clubes')->findOrFail($id);

        return response()->json($jugador->clubes);
    }

    // Actualiza la relación de clubes de un jugador usando sync
    public function updateClubes(Request $request, $id)
    {
        $jugador = Jugador::findOrFail($id);

        $clubes = $request->input('clubes', []);

        $jugador->clubes()->sync($clubes);

        return response()->json([
            'message' => 'Clubes actualizados correctamente'
        ]);
    }

    // Busca jugadores por nombre con un límite de resultados
    public function search(Request $request)
    {
        $q = $request->get('search');
        return Jugador::where('nombre_jugador', 'like', "%$q%")
            ->limit(10)
            ->get();
    }
}
