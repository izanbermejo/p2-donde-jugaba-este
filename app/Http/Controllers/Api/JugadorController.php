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
        $this->authorize('jugador-list');

        $perPage = $request->input('rows', 10);
        $page = $request->input('page', 1);

        $query = Jugador::with('pais');

        // FILTROS
        if ($request->id_jugador) {
            $query->where('id_jugador', $request->id_jugador);
        }

        if ($request->nombre_jugador) {
            $query->where('nombre_jugador', 'like', "%{$request->nombre_jugador}%");
        }

        if ($request->posicion_jugador) {
            $query->where('posicion_jugador', 'like', "%{$request->posicion_jugador}%");
        }

        if ($request->club_actual_jugador) {
            $query->where('club_actual_jugador', 'like', "%{$request->club_actual_jugador}%");
        }

        if ($request->pais) {
            $query->whereHas('pais', function ($q) use ($request) {
                $q->where('nombre_pais', 'like', "%{$request->pais}%");
            });
        }

        // ORDENAR
        $sortField = $request->input('sortField');
        $sortOrder = (int) $request->input('sortOrder', 1);

        $direction = $sortOrder === -1 ? 'desc' : 'asc';

        $allowedFields = [
            'id_jugador',
            'nombre_jugador',
            'fecha_nacimiento_jugador',
            'posicion_jugador',
            'club_actual_jugador'
        ];

        if ($sortField && in_array($sortField, $allowedFields)) {
            $query->orderBy($sortField, $direction);
        } else {
            $query->orderBy('id_jugador', 'asc');
        }
        
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
    // Devuelve los datos de un jugador por su ID
    public function show($id_jugador){
        $this->authorize('jugador-list');

        $jugador = Jugador::find($id_jugador);
        return $jugador;
    }

    // Elimina un jugador por su ID
    public function destroy($id_jugador){
        $this->authorize('jugador-delete');

        $jugador = Jugador::find($id_jugador);
        $jugador->delete();

        return response()->json([
            'message' => 'Jugador eliminado correctamente',
            'data' => $jugador
        ]);
    }

    // Crea un nuevo jugador validando los datos de entrada
    public function store(StoreJugadorRequest $request){
        $this->authorize('jugador-create');

        $data = $request->validated();
        $jugador = Jugador::create($data);
        return $jugador;
    }

    // Actualiza los datos de un jugador existente
    public function update(UpdateJugadorRequest $request, $id_jugador){
        $this->authorize('jugador-edit');

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
        $this->authorize('jugador-edit');
        
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
        $q = $request->input('search');
        return Jugador::where('nombre_jugador', 'like', "%$q%")
            ->limit(10)
            ->get();
    }
}
