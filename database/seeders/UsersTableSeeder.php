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
            2 =>
            array (
                'id' => 3,
                'name' => 'Laura',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'Laura',
                'email' => 'laura@laura.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'David',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'David',
                'email' => 'david@david.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Joao',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'Joao',
                'email' => 'joao@joao.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Izan',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'Izan',
                'email' => 'izan@Izan.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Iker',
                'surname1' => '',
                'surname2' => '',
                'alias' => 'Iker',
                'email' => 'iker@iker.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('1234'),
                'remember_token' => NULL,
                'created_at' => '2025-07-25 08:51:50',
                'updated_at' => '2025-07-25 08:51:50',
            ),
        ));


    }
}
