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
        Schema::create('rankings', function (Blueprint $table) {
            $table->unsignedInteger('id_partida');

            $table->integer('id_juego');
            $table->unsignedBigInteger('id_usuario');

            $table->integer('dificultad');

            $table->integer('puntuacion')->default(0);

            $table->timestamp('fecha');

            $table->primary(['id_juego', 'id_usuario']);
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_juego')->references('id_juego')->on('juegos')->onDelete('cascade');
            $table->foreign('id_partida')->references('id_partida')->on('partidas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};
