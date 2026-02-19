<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JugadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/jugadores.csv');

        if (!file_exists($path)){
            echo "Archivo no encontrado";
            return;
        }

        \DB::table('jugadores')->delete();

        $file = fopen($path, 'r');

        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            \DB::table('jugadores') -> insert ([
                'id_jugador' => $row[0],
                'slug_jugador' => $row[1],
                'nombre_jugador' => $row[2],
                'fecha_nacimiento_jugador' => $row[4],
                'pais_jugador' => $row[5],
                'posicion_jugador' => $row[6],
                'club_actual_jugador' => $row[7],
            ]);
        }
        fclose($file);
    }
}
