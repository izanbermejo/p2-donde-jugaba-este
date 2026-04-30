<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JugadoresTableSeeder extends Seeder
{
    // Ejecuta el seeder para cargar jugadores desde un archivo CSV
    public function run(): void
    {
        $path = database_path('data/jugadores.csv');

        // Comprueba si el archivo existe antes de continuar
        if (!file_exists($path)){
            echo "Archivo no encontrado";
            return;
        }

        // Elimina todos los registros existentes de la tabla jugadores
        \DB::table('jugadores')->delete();

        $file = fopen($path, 'r');

        // Lee la cabecera del CSV y la ignora
        $header = fgetcsv($file);

        // Recorre cada fila del CSV e inserta los datos en la base de datos
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
