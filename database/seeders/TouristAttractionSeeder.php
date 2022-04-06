<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TouristAttractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tourist_attraction')->truncate();
        DB::table('tourist_attraction')->insert([
            'name' => 'Farm House',
            'address' => 'Dago',
            'id_open_close' => 1,
            'phone' => '08123456789',
            'email_contact' => 'farmhouse@example.com',
            'website_information' => 'farmhouse.example.com',
            'created_by' => 'admin',
            'updated_by' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
