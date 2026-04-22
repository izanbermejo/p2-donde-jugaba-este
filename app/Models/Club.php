<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubes';

    protected $primaryKey = 'id_club';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = ['id_club', 'slug_club', 'nombre_club', 'logo_url', 'pais_club','id_liga_club', 'dificultad_club'];

    public function liga() {
        return $this->belongsTo(Liga::class, 'id_liga_club', 'id_liga');
    }

    public function jugadores()
    {
        return $this->belongsToMany(Jugador::class, 'jugador_has_club', 'id_club', 'id_jugador');
    }
}
