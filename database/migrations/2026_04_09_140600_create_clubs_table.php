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
        Schema::create('clubes', function (Blueprint $table) {
            $table->integer('id_club')->primary();
            $table->string('slug_club');
            $table->string('nombre_club');
            $table->string('logo_url')->nullable();
            $table->string('pais_club');
            $table->string('id_liga_club', 5);
            $table->string('dificultad_club');

            $table->foreign('id_liga_club')->references('id_liga')->on('ligas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubes');
    }
};
