<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLigaRequest;
use App\Http\Requests\UpdateLigaRequest;
use App\Models\Liga;


class LigaController extends Controller
{
    public function index(){
        $this->authorize('liga-list');

        $ligas = Liga::all();
        return $ligas;
    }

    public function show($id_liga){
        $this->authorize('liga-list');

        $liga = Liga::find($id_liga);
        return $liga;
    }

    public function destroy($id_liga){
        $this->authorize('liga-delete');

        $liga = Liga::find($id_liga);
        $liga->delete();

        return response()->json([
            'message' => 'Liga eliminada correctamente',
            'data' => $liga
        ]);
    }

    public function store(StoreLigaRequest $request){
        $this->authorize('liga-create');

        $data = $request->validated();
        $liga = Liga::create($data);
        return $liga;
    }

    public function update(UpdateLigaRequest $request, $id_liga){
        $this->authorize('liga-edit');

        $liga = Liga::find($id_liga);
        $liga->update($request->validated());


        return response()->json([
            'message' => 'Liga actualizada correctamente',
            'data' => $liga->fresh()
        ]);
    }
}
