<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    protected $table = 'jugadores';

    protected $primaryKey = 'id_jugador';
    public $incrementing = false;
    protected $keyType = 'integer';
    public $timestamps = false;
    
    protected $fillable = [
        'id_jugador',
        'slug_jugador', 
        'nombre_jugador', 
        'fecha_nacimiento_jugador', 
        'pais_jugador', 
        'posicion_jugador', 
        'club_actual_jugador'
    ];
}
