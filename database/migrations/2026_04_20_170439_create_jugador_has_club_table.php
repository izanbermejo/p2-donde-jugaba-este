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
        Schema::create('jugador_has_club', function (Blueprint $table) {
            $table->integer('id_jugador');
            $table->integer('id_club');

            $table->primary(['id_jugador', 'id_club']);
            $table->foreign('id_jugador')->references('id_jugador')->on('jugadores');
            $table->foreign('id_club')->references('id_club')->on('clubes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugador_has_club');
    }
};
