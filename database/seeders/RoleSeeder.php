<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
            array(
              'idRL' => 1,
              'libelRL' => 'admin'
            ),
            array(
                'idRL' => 2,
                'libelRL' => 'user'
              ),
        ));
    }
}
