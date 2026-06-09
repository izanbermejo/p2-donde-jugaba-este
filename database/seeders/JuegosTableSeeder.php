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
                'slug_juego'=>'match9',
                'descripcion_juego'=>'Juego de lógica futbolística en formato 3x3 donde deberás completar un tablero rellenando cada casilla con un jugador que cumpla simultáneamente los requisitos de su fila y su columna (Su nacionalidad y un club en el que haya jugado).

                Cada combinación siempre tiene al menos un jugador válido, pero no podrás repetir jugadores dentro del mismo tablero, por lo que deberás pensar bien cada elección. Además, los requisitos no se repiten, lo que hace que cada partida sea única y equilibrada.

                Por cada acierto obtendrás una puntuación fija, y si consigues completar el tablero entero recibirás una bonificación adicional. Tu puntuación final también dependerá del tiempo que tardes en completar el reto, premiando las resoluciones más rápidas.

                El juego cuenta con un sistema de clasificación donde podrás ver tu mejor partida clasificada en rankings globales tanto por mejor puntuación en una partida como por puntuación total acumulada.'
            ),
            1 => array(
                'id_juego'=>'2',
                'nombre_juego'=>'Path4',
                'slug_juego'=>'path4',
                'descripcion_juego'=>'Juego de deducción futbolística donde deberás adivinar un jugador a partir de los equipos por los que ha pasado durante su carrera.

                Al comenzar cada ronda se mostrará un primer club en el que ha jugado el futbolista. Si no consigues acertarlo, podrás revelar un segundo equipo, después un tercero y finalmente un cuarto. El orden en el que aparecen los clubes no corresponde necesariamente al recorrido real de su carrera, por lo que deberás utilizar tus conocimientos futbolísticos para relacionar las pistas y encontrar la respuesta correcta.

                Todos los jugadores incluidos en el juego han militado en al menos cuatro equipos diferentes, garantizando que siempre existan suficientes pistas para resolver cada desafío. Cuantos menos equipos necesites revelar para acertar, mayor será la puntuación obtenida. Además, el tiempo empleado también influirá en la puntuación final, premiando a los jugadores más rápidos y precisos.

                El juego cuenta con un sistema de clasificación donde podrás competir con otros usuarios y consultar rankings globales tanto por mejor puntuación en una partida como por puntuación total acumulada.'
            ),
        ));

    }
}
