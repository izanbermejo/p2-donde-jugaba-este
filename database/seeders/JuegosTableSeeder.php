<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JuegosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \DB::table('juegos')->delete();

        \DB::table('juegos')->insert(array(
            0 => array(
                'id_juego'=>'1',
                'nombre_juego'=>'Match9',
                'descripcion_juego'=>'Juego de lógica futbolística en formato 3x3 donde deberás completar un tablero rellenando cada casilla con un jugador que cumpla simultáneamente los requisitos de su fila y su columna (Su nacionalidad y un club en el que haya jugado).

                Cada combinación siempre tiene al menos un jugador válido, pero no podrás repetir jugadores dentro del mismo tablero, por lo que deberás pensar bien cada elección. Además, los requisitos no se repiten, lo que hace que cada partida sea única y equilibrada.

                Por cada acierto obtendrás una puntuación fija, y si consigues completar el tablero entero recibirás una bonificación adicional. Tu puntuación final también dependerá del tiempo que tardes en completar el reto, premiando las resoluciones más rápidas.

                El juego cuenta con un sistema de clasificación donde podrás ver tu mejor partida clasificada en rankings globales tanto por mejor puntuación en una partida como por puntuación total acumulada.'
            ),
        ));
    }
}
