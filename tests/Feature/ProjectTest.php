<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;

class ProjectTest extends TestCase{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    public function testProjectHTTPGet() {
        $response = $this->get('/project');
        $response->assertStatus(200);
    }

    public function testIfProjectContainsPageTitle(){
        $response = $this->get('/project');
        $value = "<h1>Liste de projets</h1>";
        $response->assertSee($value, $escaped = false);
    }

    public function testFirstProjectName() {
        $projects= Project::factory()->count(10)->create();
        $response = $this->get('/project');
        $value = $projects[0]->name;
        $response->assertSee($value, $escaped = true);
    }

    public function testDisplayProjectNameOnProjectPage() {
        $projects= Project::factory()->count(10)->create();
        $response = $this->get('/project/1');
        $value = $projects[0]->name;
        $response->assertSee($value, $escaped = true);
    }

    public function testAuthorRelationship() {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $project->user);
    }

    public function testAuthorNameOnProjectPage(){
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $response = $this->get('project/1');
        $value = $project->user->first_name;
        $response->assertSee($value, $escaped = true);
    }

    public function testAuthUserCanAddProject() {
        $user = User::factory()->create();
        $formInfos = [
            'name' => 'le projet du cul',
            'description' => 'la description du cul',
            'date' => date("Y/m/d"),
            'author' => $user->id
        ];
        $response = $this->actingAs($user)
                        ->post('/project-create', $formInfos);

        $response_1 = $this->get('/project')
                        ->assertSee('le projet du cul');
    }

    public function testNonAuthUserCantAddProject(){
        $user = User::factory()->create();
        $formInfos = [
            'name' => 'le projet du cul',
            'description' => 'la description du cul',
            'date' => date("Y/m/d"),
            'author' => $user->id
        ];
        $response = $this->post('/project-create', $formInfos);

        $response_1 = $this->get('/project')
                        ->assertDontSee('le projet du cul');
    }

    public function testNonAuthCantAddProject(){
        $value = '<form action="/project-create" method="POST">';
        $response = $this->get('/project')
                    ->assertDontSee($value, $escaped=false);
    }

    public function testAuthCanAddProject(){
        $value = '<form action="/project-create" method="POST">';
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                    ->get('/project')
                    ->assertSee($value, $escaped=false);
    }

    public function testOnlyAuthorCanEditProject() {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $path = '/project/' . $project->id;

        $response = $this->actingAs($user)
                        ->get($path)
                        ->assertSee('Modifier ce projet');

        $response1 = $this->actingAs($user1)
                        ->get($path)
                        ->assertDontSee('Modifier ce projet');

        $response2 =$this->actingAs($user1)
                        ->get('/project-edit/' . $project->id)
                        ->assertStatus(302);

        $newInfos = [
            'name' => 'weeeesh',
            'description' => 'la description du cul',
            'date' => date("Y/m/d"),
            'author' => $user->id
        ];
        $response3 = $this->actingAs($user1)
                        ->post('/project-edit/' . $project->id, $newInfos)
                        ->dump();

        $response4 = $this->get('/project')
                    ->assertDontSee('weeeesh');
    }
}
