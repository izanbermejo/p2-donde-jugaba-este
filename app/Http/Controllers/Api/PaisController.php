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

    public function show(Pais $pais){
        return $pais;
    }

    public function destroy(Pais $pais){
        $pais->delete();
    }

    public function store(StorePaisRequest $request){
        $data = $request->validated();
        $pais = Pais::create($data);
        return $pais;
    }

    public function update(UpdatePaisRequest $request, Pais $pais){
        $pais->update($request->validated());
        return $pais;
    }
}
