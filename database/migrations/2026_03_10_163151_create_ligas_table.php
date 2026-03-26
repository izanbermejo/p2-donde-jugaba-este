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
        Schema::create('ligas', function (Blueprint $table) {
            $table->string('id_liga', 5)->primary();
            $table->string('nombre_liga', 50);
            $table->string('pais_liga', 30);
            $table->enum('dificultad_liga', ['0', '1', '2', '3']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligas');
    }
};
