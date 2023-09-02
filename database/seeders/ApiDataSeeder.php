<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('apikeys')->insert([
            'key' => Str::random(40), // Generate a random API key
            'user_id' => 1, // You can associate keys with users if needed
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
