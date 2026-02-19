<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaisRequest;
use App\Http\Requests\UpdatePaisRequest;
use App\Models\Pais;


class PaisController extends Controller
{
    public function index(){
        $paises = Pais::all();
        return $paises;
    }

    public function show($id_pais){
        $pais = Pais::find($id_pais);
        return $pais;
    }

    public function destroy($id_pais){
        $pais = Pais::find($id_pais);
        $pais->delete();

        return response()->json([
            'message' => 'País eliminado correctamente',
            'data' => $pais
        ]);
    }

    public function store(StorePaisRequest $request){
        $data = $request->validated();
        $pais = Pais::create($data);
        return $pais;
    }

    public function update(UpdatePaisRequest $request, $id_pais){
        
        $pais = Pais::find($id_pais);
        $pais->update($request->validated());


        return response()->json([
            'message' => 'País actualizado correctamente',
            'data' => $pais->fresh()
        ]);
    }
}
