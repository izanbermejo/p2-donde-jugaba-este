<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JugadorHasClubTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/jugador_has_club.csv');

        if (!file_exists($path)){
            echo "Archivo no encontrado";
            return;
        }

        \DB::table('jugador_has_club')->delete();

        $file = fopen($path, 'r');

        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            \DB::table('jugador_has_club')->insert([
                'id_jugador' => $row[0],
                'id_club' => $row[1],
            ]);
        }

        fclose($file);
    }
}