<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class PostApiTest extends TestCase
{
    use RefreshDatabase; // Refresh the database before each test
    use WithFaker; // Use Faker for generating test data
    
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Sanctum::actingAs($user);    

        /* $user = User::factory()->create();        
        //$this->actingAs($user, 'api');
        // Generate a token for the user
        $token = $user->createToken('test-token')->plainTextToken;        
        // Set the token in the HTTP headers for authentication
        $this->withHeader('Authorization', 'Bearer ' . $token);     */    
    }
    public function tesst_create_post()
    {
        // $newPost = Post::factory()->make();        
        // $newPost = $newPost->toArray();
        $newPost = [
            'title' => $this->faker->sentence." test",
            'description' => $this->faker->paragraph
        ];
        // Create a new Post using an API POST request
        $response = $this->postJson('/api/v1/posts', $newPost);

        // Assert that the response status is HTTP 201 Created
        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', $newPost);
    }

    public function test_read_post()
    {
        // Create a Category and Post (you can use factory for this)
        $category = Category::factory()->create();

        $post = Post::factory()->create();
        $post->categories()->sync(
            $category->id
        );
        // Retrieve the Post using an API GET request
        $response = $this->get("/api/v1/posts/{$post->id}");
  
        /* $this->assertEquals(
            $post->title,
            $response->data->title,
            "actual value is not equals to expected"
        ); */
                
        // Assert that the response status is HTTP 200 OK
        $response->assertStatus(200);
    }

    public function test_update_post()
    {

        // Create a Category and Post (you can use factory for this)
        $category = Category::factory()->create();

        $post = Post::factory()->create();
        $post->categories()->sync(
            $category->id
        );

        $updatePost = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        // Update the Post using an API PUT request
        $response = $this->putJson("/api/v1/posts/{$post->id}", $updatePost);

        // Assert that the response status is HTTP 200 OK
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('posts', $updatePost);
    }

    public function tesst_delete_post()
    {
   
        // Create a Category and Post (you can use factory for this)
        $category = Category::factory()->create();
        $user = User::factory()->create();
        
        $post = Post::factory()->create();
        $post->categories()->sync(
            $category->id
        );

        // Delete the Post using an API DELETE request
        $response = $this->deleteJson("/api/v1/posts/{$post->id}");

        // Assert that the response status is HTTP 204 No Content
        $response->assertStatus(204);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
