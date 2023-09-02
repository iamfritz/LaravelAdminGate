<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Apikey;

class ApiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apikey::create([
            'key' => "1234abc5678", // Generate a random API key
            'user_id' => 1, // You can associate keys with users if needed
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
