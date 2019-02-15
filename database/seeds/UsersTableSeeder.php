<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'role_id' => '1',
            'name' => 'Md. Admin',
            'username' => 'admin',
            'email' => 'shishir.srdr16@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Mst. Editor',
            'username' => 'editor',
            'email' => 'jarinritu9@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
