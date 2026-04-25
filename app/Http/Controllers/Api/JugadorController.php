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
    public function index(Request $request)
    {
        $query = Jugador::query();

        // 🔍 filtro por nombre (autocompletado)
        if ($request->has('search') && $request->search != '') {
            $query->where('nombre_jugador', 'LIKE', '%' . $request->search . '%');
        }

        // ⚠️ importante: limitar resultados
        return $query->limit(10)->get();
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

    public function indexByIdPais($id_pais){
        $jugadores = Jugador::where('pais_jugador', $id_pais)->get();
        return $jugadores;
    }

    public function indexByIdPosicion($id_posicion){
        $jugadores = Jugador::where('posicion_jugador', $id_posicion)->get();
        return $jugadores;
    }

    public function getClubes($id)
    {
        $jugador = Jugador::with('clubes')->findOrFail($id);

        return response()->json($jugador->clubes);
    }

    public function updateClubes(Request $request, $id)
    {
        $jugador = Jugador::findOrFail($id);

        $clubes = $request->input('clubes', []);

        $jugador->clubes()->sync($clubes);

        return response()->json([
            'message' => 'Clubes actualizados correctamente'
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->get('search');

        return Jugador::where('nombre', 'like', "%$q%")
            ->limit(10)
            ->get();
    }
}