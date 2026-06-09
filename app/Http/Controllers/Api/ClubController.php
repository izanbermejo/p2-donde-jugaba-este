<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\UpdateClubRequest;
use Illuminate\Http\Request;
use App\Models\Club;
class ClubController extends Controller
{
    public function index(){
        $this->authorize('club-list');

        $clubes = Club::with('liga')->get();
        return $clubes;
    }

    public function show($id_club){
        $this->authorize('club-list');

        $club = Club::find($id_club);
        return $club;
    }

    public function destroy($id_club){
        $this->authorize('club-delete');

        $club = Club::find($id_club);
        $club->delete();

        return response()->json([
            'message' => 'Club eliminado correctamente',
            'data' => $club
        ]);
    }

    public function store(StoreClubRequest $request){
        $this->authorize('club-create');

        $data = $request->validated();
        $club = Club::create($data);
        return $club;
    }

    public function update(UpdateClubRequest $request, $id_club){
        $this->authorize('club-edit');
        
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

    public function updateImg(Request $request)
    {
        
        $request->validate([
            'id' => 'required|exists:clubes,id_club',
            'picture' => 'required|image|max:2048',
        ]);

        $club = Club::findOrFail($request->id);

        $path = $request->file('picture')->store('clubes', 'public');

        $club->logo_url = $path;
        $club->save();

        return response()->json([
            'message' => 'Imagen subida correctamente',
            'path' => $path,
            'club' => $club
        ]);
    }
}
