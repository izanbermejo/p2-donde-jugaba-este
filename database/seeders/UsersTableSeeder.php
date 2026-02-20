<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Admin',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'User',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'user',
                'email' => 'user@user.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
        ));


    }
}
