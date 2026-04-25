<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id_juego';

    protected $fillable = [
        'id_juego',
        'nombre'
    ];

    /* ======================
       RELACIONES
    ====================== */

    public function partidas()
    {
        return $this->hasMany(Partida::class, 'id_juego');
    }
}