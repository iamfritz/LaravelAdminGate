<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class AuthApiTest extends TestCase
{
    use RefreshDatabase; // Refresh the database before each test
    use WithFaker; // Use Faker for generating test data
    
    protected function setUp(): void
    {
        parent::setUp();

        /* create API keys */
        /* add api key to header request */
        /* $user = User::factory()->create();        
        //$this->actingAs($user, 'api');
        // Generate a token for the user
        $token = $user->createToken('test-token')->plainTextToken;        
        // Set the token in the HTTP headers for authentication
        $this->withHeader('Authorization', 'Bearer ' . $token); */        
    }
    /* public function test_register_post()
    {
        $newUser = User::factory();
        // Create a new User using an API POST request
        $response = $this->postJson('/api/v1/register', $newUser);

        // Assert that the response status is HTTP 201 Created
        $response->assertStatus(201);
    }    
    public function test_login_post()
    {
        $newUser = User::factory()->create();
        $loginUser = [
                        'email'     => $newUser['email'],
                        'password'  => 'password'
                    ];
        // Create a new User using an API POST request
        $response = $this->postJson('/api/v1/login', $loginUser);

        // Assert that the response status is HTTP 201 Created
        $response->assertStatus(201);
    } */
}
