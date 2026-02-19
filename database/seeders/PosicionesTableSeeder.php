<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PosicionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('posiciones')->delete();

        \DB::table('posiciones')->insert(array(
            0 => array('id_posicion' => 'DC', 'rol' => 'Ataque', 'posicion' => 'Delantero Centro'),
            1 => array('id_posicion' => 'ED', 'rol' => 'Ataque', 'posicion' => 'Extremo Derecho'),
            2 => array('id_posicion' => 'EI', 'rol' => 'Ataque', 'posicion' => 'Extremo Izquierdo'),
            3 => array('id_posicion' => 'SD', 'rol' => 'Ataque', 'posicion' => 'Segundo Delantero'),
            4 => array('id_posicion' => 'DFC', 'rol' => 'Defensa', 'posicion' => 'Central'),
            5 => array('id_posicion' => 'LD', 'rol' => 'Defensa', 'posicion' => 'Lateral Derecho'),
            6 => array('id_posicion' => 'LI', 'rol' => 'Defensa', 'posicion' => 'Lateral Izquierdo'),
            7 => array('id_posicion' => 'MD', 'rol' => 'Mediocampo', 'posicion' => 'Medio Derecho'),
            8 => array('id_posicion' => 'MI', 'rol' => 'Mediocampo', 'posicion' => 'Medio Izquierdo'),
            9 => array('id_posicion' => 'MC', 'rol' => 'Mediocampo', 'posicion' => 'Mediocentro'),
            10 => array('id_posicion' => 'MCD', 'rol' => 'Mediocampo', 'posicion' => 'Mediocentro Defensivo'),
            11 => array('id_posicion' => 'MCO', 'rol' => 'Mediocampo', 'posicion' => 'Mediocentro Ofensivo'),
            12 => array('id_posicion' => 'POR', 'rol' => 'Portero', 'posicion' => 'Portero'),
        ));
    }
}
