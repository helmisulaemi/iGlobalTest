<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'useradmin',
            'usergroup' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => Hash::make('secret'),
        ]);

        DB::table('users')->insert([
            'name' => 'useremployee',
            'usergroup' => 'Employee',
            'email' => 'Employee@gmail.com',
            'password' => Hash::make('secret'),
        ]);
    }
}
