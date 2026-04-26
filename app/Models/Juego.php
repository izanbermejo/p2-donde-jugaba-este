<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id_juego';

    protected $fillable = [
        'id_juego',
        'nombre_juego',
        'slug_juego',
        'descripcion_juego',
    ];
}
