<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePosicionRequest;
use App\Http\Requests\UpdatePosicionRequest;
use App\Models\Posicion;


use Illuminate\Http\Request;

class PosicionController extends Controller
{
    public function index(){
        $posiciones = Posicion::all();
        return $posiciones;
    }

    public function show($id_posicion){
        $posicion = Posicion::find($id_posicion);
        return $posicion;
    }

    public function destroy($id_posicion){
        $posicion = Posicion::find($id_posicion);
        $posicion->delete();

        return response()->json([
            'message' => 'Posicion eliminada correctamente',
            'data' => $posicion
        ]);
    }

    public function store(StorePosicionRequest $request){
        $data = $request->validated();
        $posicion = Posicion::create($data);
        return $posicion;
    }

    public function update(UpdatePosicionRequest $request, $id_posicion){
        
        $posicion = Posicion::find($id_posicion);
        $posicion->update($request->validated());


        return response()->json([
            'message' => 'Posicion actualizada correctamente',
            'data' => $posicion->fresh()
        ]);
    }
}
