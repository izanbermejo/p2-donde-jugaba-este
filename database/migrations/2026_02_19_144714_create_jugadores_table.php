<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->integer('id_jugador')->primary();
            $table->string('slug_jugador');
            $table->string('nombre_jugador');
            $table->date('fecha_nacimiento_jugador');
            $table->string('pais_jugador');
            $table->string('posicion_jugador');
            $table->string('club_actual_jugador');

            $table->foreign('pais_jugador')->references('id_pais')->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
