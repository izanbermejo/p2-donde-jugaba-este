<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LigasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \DB::table('ligas')->delete();

        \DB::table('ligas')->insert(array(
            0 => array('id_liga'=>'ES1','nombre_liga'=>'LaLiga','pais_liga'=>'España','dificultad_liga'=>'1'),
            1 => array('id_liga'=>'GB1','nombre_liga'=>'Premier League','pais_liga'=>'Inglaterra','dificultad_liga'=>'1'),
            2 => array('id_liga'=>'IT1','nombre_liga'=>'Serie A','pais_liga'=>'Italia','dificultad_liga'=>'1'),
            3 => array('id_liga'=>'L1','nombre_liga'=>'Bundesliga','pais_liga'=>'Alemania','dificultad_liga'=>'1'),
            4 => array('id_liga'=>'FR1','nombre_liga'=>'Ligue 1','pais_liga'=>'Francia','dificultad_liga'=>'1'),

            5 => array('id_liga'=>'NL1','nombre_liga'=>'Eredivisie','pais_liga'=>'Países Bajos','dificultad_liga'=>'2'),
            6 => array('id_liga'=>'PO1','nombre_liga'=>'Primeira Liga','pais_liga'=>'Portugal','dificultad_liga'=>'2'),
            7 => array('id_liga'=>'TR1','nombre_liga'=>'Süper Lig','pais_liga'=>'Turquía','dificultad_liga'=>'2'),

            8 => array('id_liga'=>'BE1','nombre_liga'=>'Jupiler Pro League','pais_liga'=>'Bélgica','dificultad_liga'=>'3'),
            9 => array('id_liga'=>'GR1','nombre_liga'=>'Super League','pais_liga'=>'Grecia','dificultad_liga'=>'3'),
            10 => array('id_liga'=>'ARGC','nombre_liga'=>'Primera División','pais_liga'=>'Argentina','dificultad_liga'=>'3'),
            11 => array('id_liga'=>'BRA1','nombre_liga'=>'Brasileirão','pais_liga'=>'Brasil','dificultad_liga'=>'3'),
            12 => array('id_liga'=>'MLS1','nombre_liga'=>'MLS','pais_liga'=>'Estados Unidos','dificultad_liga'=>'3'),
            13 => array('id_liga'=>'MEXA','nombre_liga'=>'Liga MX','pais_liga'=>'México','dificultad_liga'=>'3'),
            14 => array('id_liga'=>'SC1','nombre_liga'=>'Scottish Premiership','pais_liga'=>'Escocia','dificultad_liga'=>'3'),
        ));
    }
}
