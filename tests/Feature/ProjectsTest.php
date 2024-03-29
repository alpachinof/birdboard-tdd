<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $attributes = [
            'title' => 'something',
            'description' => 'smth else',
            'notes' => 'general notes'
        ];

        $this->post('/projects', $attributes)->assertRedirect();


        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description']);
    }
    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->patch($project->path(), [
            'notes' => 'changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'notes' => 'changed'
        ]);
    }
    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }
    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path(), [])->assertStatus(403);
    }
    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $this->post('/projects', [])->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $this->post('/projects', [])->assertSessionHasErrors('description');
    }
    /** @test */
    public function guests_cannot_control_projects()
    {
        $project = Project::factory()->create();

        $this->post('/projects', [$project->toArray()])->assertRedirect('login');
        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }
}
