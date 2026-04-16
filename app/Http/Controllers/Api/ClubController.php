<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\UpdateClubRequest;
use App\Models\Club;

class ClubController extends Controller
{
    public function index(){
        $clubes = Club::with('liga')->get();
        return $clubes;
    }

    public function show($id_club){
        $club = Club::find($id_club);
        return $club;
    }

    public function destroy($id_club){
        $club = Club::find($id_club);
        $club->delete();

        return response()->json([
            'message' => 'Club eliminado correctamente',
            'data' => $club
        ]);
    }

    public function store(StoreClubRequest $request){
        $data = $request->validated();
        $club = Club::create($data);
        return $club;
    }

    public function update(UpdateClubRequest $request, $id_club){
        $club = Club::find($id_club);
        $club->update($request->validated());


        return response()->json([
            'message' => 'Club actualizado correctamente',
            'data' => $club->fresh()
        ]);
    }

    public function indexByIdPais($id_pais){
        $clubes = Club::where('pais_club', $id_pais)->get();
        return $clubes;
    }

    public function indexByIdPosicion($id_posicion){
        $clubes = Club::where('posicion_club', $id_posicion)->get();
        return $clubes;
    }
}
