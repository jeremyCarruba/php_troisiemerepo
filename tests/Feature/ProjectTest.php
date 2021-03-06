<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use RefreshDatabase;

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
                        ->post('/project-create', $formInfos)
                        ->assertStatus(201);

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
        $response = $this->post('/project-create', $formInfos)
                    ->assertUnauthorized();

        $response_1 = $this->get('/project')
                        ->assertDontSee('le projet du cul');
    }

    public function testNonAuthCantAddProject(){
        $value = '<form action="/project-create" method="POST">';
        $response = $this->get('/project')
                    ->assertDontSee($value, $escaped=false);
    }

    public function testAuthCanAddProject(){
        $user = User::factory()->create();

        $newInfos = [
            'name' => 'weeeesh',
            'description' => 'la description du cul',
            'date' => date("Y/m/d"),
            'author' => $user->id
        ];

        $response = $this
        ->post('/project-create', $newInfos)
        ->assertUnauthorized();

        $response = $this->actingAs($user)
                    ->post('/project-create', $newInfos)
                    ->assertStatus(201);
    }

    public function testOnlyAuthorCanEditProject() {
        $author = User::factory()->create();
        $notAuthor = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $author->id]);

        $newInfos = [
            'name' => 'weeeesh',
            'description' => 'la description du cul',
            'date' => date("Y/m/d"),
            'author' => $author->id
        ];

        $response1 = $this->actingAs($notAuthor)
                        ->post('/project-edit/' . $project->id, $newInfos)
                        ->assertUnauthorized();

        $response2 =$this->actingAs($author)
                        ->post('/project-edit/' . $project->id, $newInfos)
                        ->assertStatus(201);
        $response3 = $this->get('/project')
                        ->assertSee('weeeesh');;

    }
}
