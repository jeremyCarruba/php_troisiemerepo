<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;


class DonationTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use RefreshDatabase;

    public function testUserCanHaveMultipleDonations()
    {
        $user = User::factory()->create();
        $donation = Donation::factory()->count(10)->create(['user_id' => $user->id]);

        $donations = $user->donations;
        foreach ($donations as $donation) {
            $this->assertInstanceOf(Donation::class, $donation);
        }
    }

    public function testProjectCanHaveMultipleDonations()
    {
        $project = Project::factory()->create();
        $donation = Donation::factory()->count(10)->create(['project_id' => $project->id]);

        $projectDonations = $project->donations;
        foreach ($projectDonations as $donation) {
            $this->assertInstanceOf(Donation::class, $donation);
        }
    }

    public function testAuthCanDonate(){
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $donation = [
            'amount' => 1000,
            'project_id' => $project->id
        ];
        $response = $this
        ->actingAs($user)
                ->post('/donation-create', $donation)
                ->assertSuccessful();
    }

    public function testNonAuthCantDonate(){
        $project = Project::factory()->create();
        $donation = [
            'amount' => 1000,
            'project_id' => $project->id
        ];
        $response1 = $this->post('/donation-create', $donation)
        ->assertUnauthorized();
    }

    public function testOnlyOwnerCanSeeDonations(){
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $donation1 = Donation::factory()->create(['project_id' => $project->id, 'user_id' => $user->id]);
        $donation2 = Donation::factory()->create(['project_id' => $project->id, 'user_id' => $user1->id]);

        $response = $this->actingAs($user)
                    ->get('/project/'. $project->id)
                    ->assertSee('Donation = '.$donation1->amount);

        $response1 = $this->actingAs($user)
                    ->get('/project/'. $project->id)
                    ->assertDontSee('Donation = '.$donation2->amount);
    }
}
