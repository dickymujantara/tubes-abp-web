<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Tom',
            'address' => 'Bandung',
            'username' => 'tom',
            'email' => 'tom@example.com',
            'password' => Hash::make('qwerty123'),
            'has_verified_email' => 1,
            'email_verification_token' => null,
            'email_verified_at' => now(),
            'role' => "GENERAL",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('users')->insert([
            'name' => 'Admin',
            'address' => 'Bandung',
            'username' => 'admin2',
            'email' => 'admin@example.com',
            'password' => Hash::make('qwerty123'),
            'has_verified_email' => 1,
            'email_verification_token' => null,
            'email_verified_at' => now(),
            'role' => "ADMIN",
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
