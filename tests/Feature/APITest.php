<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApiProjectNameOnAllProjects()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/project');
        $response->assertStatus(200);
        $response->assertJsonFragment([$project->name]);
    }

    public function testApiProjectNameOnProjectPage()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/project/' . $project->id);
        $response->assertStatus(200);
        $response->assertJsonFragment([$project->name]);
    }
}
