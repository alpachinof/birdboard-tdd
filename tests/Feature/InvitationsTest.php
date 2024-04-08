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
    public function a_project_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'some task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
