<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    protected $table = 'ligas';

    protected $primaryKey = 'id_liga';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = ['id_liga', 'nombre_liga', 'pais_liga', 'dificultad_liga'];
}
