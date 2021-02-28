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
              'id' => 1,
              'libel' => 'Admin'
            ),
            array(
              'id' => 2,
              'libel' => 'User'
              ),
        ));
    }
}
