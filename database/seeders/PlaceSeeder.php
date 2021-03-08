<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('place')->insert(array(
            array(
              'libel' => 'A1'
            ),
            array(
                'libel' => 'A2'
            ),
            array(
                'libel' => 'B1'
            ),
            array(
                'libel' => 'B2'
            ),
            array(
                'libel' => 'C1'
            ),
            // array(
            //     'libel' => 'C2'
            // ),
            // array(
            //     'libel' => 'D1'
            // ),
            // array(
            //     'libel' => 'D2'
            // ),
            // array(
            //     'libel' => 'E1'
            // ),
            // array(
            //     'libel' => 'E2'
            // ),
        ));
    }
}
