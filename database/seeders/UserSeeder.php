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
            'name' => 'admin',
            'lname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            ),
            array(
            'name' => 'user1',
            'lname' => 'user1',
            'email' => 'user1@user1.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user2',
            'lname' => 'user2',
            'email' => 'user2@user2.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user3',
            'lname' => 'user3',
            'email' => 'user3@user3.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user4',
            'lname' => 'user4',
            'email' => 'user4@user4.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user5',
            'lname' => 'user5',
            'email' => 'user5@user5.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user6',
            'lname' => 'user6',
            'email' => 'user6@user6.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user7',
            'lname' => 'user7',
            'email' => 'user7@user7.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user8',
            'lname' => 'user8',
            'email' => 'user8@user8.com',
            'password' => bcrypt('helloworld'),
            ),
            array(
            'name' => 'user9',
            'lname' => 'user9',
            'email' => 'user9@user9.com',
            'password' => bcrypt('helloworld'),
            ),
        ));
    }
}
