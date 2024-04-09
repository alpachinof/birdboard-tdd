<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function non_owners_may_not_invite_users()
    {
        $project = Project::factory()->create();

        $user =  User::factory()->create();

        $this->actingAs($user)->post($project->path() . '/invitations',)
            ->assertStatus(403);
    }
    /** @test */
    public function a_project_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $userToInvite =  User::factory()->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }
    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'some task']);

        $this->assertDatabaseHas('tasks', $task);
    }

    /** @test */
    public function the_email_address_must_be_associated_with_a_valid_account()
    {
        $project = Project::factory()->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => 'notauser@gmail.com'
        ])
            ->assertSessionHasErrors('email');
    }
}
