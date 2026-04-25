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
            0 => array('id_juego'=>'1','nombre_juego'=>'Match9',),
        ));
    }
}
