<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partidas';
    protected $primaryKey = 'id_partida';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_juego',
        'id_dificultad',
        'estado',
        'puntuacion',
        'inicio',
        'fin'
    ];

    protected $casts = [
        'estado' => 'array',
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class, 'id_juego', 'id_juego');
    }
}