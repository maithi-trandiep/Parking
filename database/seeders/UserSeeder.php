<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            array(
              'nom' => 'admin',
              'prenom' => 'admin',
              'email' => 'admin@gmail.com',
              'username' => 'admin',
              'pwd' => bcrypt('password'),
              'role' => 'admin',
              'compte_active' => 1,
            ),
        ));
    }
}
