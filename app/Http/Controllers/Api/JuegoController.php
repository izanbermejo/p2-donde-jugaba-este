<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Juego;


class JuegoController extends Controller
{
    public function index(){
        $paises = Juego::all();
        return $paises;
    }

    public function show($id_juego){
        $pais = Juego::find($id_juego);
        return $pais;
    }
}
