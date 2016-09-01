<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@rempli.dev',
            'password' => bcrypt('admin_123'),
        ]);

        DB::table('users')->insert([
            'username' => 'courier',
            'email' => 'courier@rempli.dev',
            'password' => bcrypt('courier_123'),
        ]);


    }
}


