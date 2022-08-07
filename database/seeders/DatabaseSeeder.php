<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'East Vantage Admin',
            'email' => "admin@eastvantage.com",
            'password' => Hash::make('admin@123'), // admin@123
        ]);

        DB::table('roles')->insert(['id' => 1, 'name' => 'admin']);
        DB::table('roles')->insert(['id' => 2, 'name' => 'developer']);
        DB::table('roles')->insert(['id' => 3, 'name' => 'manager']);
        DB::table('roles')->insert(['id' => 4, 'name' => 'tester']);

        DB::table('user_role')->insert(['user_id' => 1, 'role_id' => 1]);
    }
}
