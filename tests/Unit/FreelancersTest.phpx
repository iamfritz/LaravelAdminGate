<?php

namespace Tests\Feature;

use App\Models\Freelancer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FreelancersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_freelancers_index(): void
    {
        $response = $this->get('/api/freelancers');

        $response->assertStatus(200);

        // Create Freelancer so that the response returns it.
        //Freelancer::factory()->create();

        $this->getJson('/api/freelancers')->assertOk();
    }

    public function test_freelancer_create()
    {
        $newFreelancer = Freelancer::factory()->make();

        $response = $this->postJson('/api/freelancers/create', $newFreelancer->toArray());

        //Assert that the response has a 201 HTTP status code:
        $response->assertCreated();

        //Assert that the response contains the given JSON data:
        $response->assertJson(['data' => ['name' => $newFreelancer->name]]);

        //Assert that a table in the database contains records matching the given key / value query constraints:
        $this->assertDatabaseHas('freelancers', $newFreelancer->toArray());
    }

    public function test_freelancer_update()
    {
        $existFreelancer = Freelancer::factory()->create();

        $newFreelancer = Freelancer::factory()->make();

        $response = $this->putJson('/api/freelancers/update/' . $existFreelancer->id, $newFreelancer->toArray());

        $response->assertJson([
            'data' => [
                'id' => $existFreelancer->id,
                'name' => $newFreelancer->name
            ],
        ]);

        $this->assertDatabaseHas('freelancers', $newFreelancer->toArray());
    }

    public function test_freelancer_delete()
    {
        $freelancer = Freelancer::factory()->create();

        $this->assertDatabaseHas('freelancers', $freelancer->toArray());

        $this->deleteJson('/api/freelancers/delete/' . $freelancer->id);

        $this->assertDatabaseMissing('freelancers', $freelancer->toArray());

    }
}
