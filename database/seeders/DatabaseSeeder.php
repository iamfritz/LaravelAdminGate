<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesDataSeeder::class);
        $this->call(UserDataSeeder::class);        
        $this->call(ApiDataSeeder::class);
        $this->call(PostCategoryDataSeeder::class);
    }
}
