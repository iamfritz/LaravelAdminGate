<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Refresh the database and seed it
        //$this->artisan('migrate:refresh --seed --migrate-configuration --env=testing');
        //$this->artisan('db:seed --class=RolesDataSeeder --env=testing');
        //$this->artisan('db:seed --class=UserDataSeeder --env=testing');
        

        // Seed the database with test data
        //$this->seed(); // This will run all seeders         
         //$this->seed(RolesDataSeeder::class);
         //$this->seed(UserDataSeeder::class);
        // Additional setup code if needed
    }    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
