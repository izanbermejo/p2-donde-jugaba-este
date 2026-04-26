<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'rankings';

    public $incrementing = false;
    protected $primaryKey = null;
    public $timestamps = false;

    protected $fillable = [
        'id_partida',
        'id_juego',
        'id_usuario',
        'dificultad',
        'puntuacion',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'datetime'
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

    public function partida()
    {
        return $this->belongsTo(Partida::class, 'id_partida', 'id_partida');
    }
}
