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
        Schema::create('partidas', function (Blueprint $table) {
            $table->increments('id_partida')->primary();

            $table->unsignedBigInteger('id_usuario');
            $table->integer('id_juego');

            $table->integer('id_dificultad');

            $table->json('estado')->nullable();

            $table->integer('puntuacion')->default(0);

            $table->timestamp('inicio');
            $table->timestamp('fin')->nullable();


            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_juego')->references('id_juego')->on('juegos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};