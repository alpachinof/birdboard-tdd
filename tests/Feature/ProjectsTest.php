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

        $this->actingAs(User::factory()->create());

        $attributes = [
            'title' => 'something',
            'description' => 'smth else'
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');


        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }
    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }
    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(User::factory()->create());

        $this->post('/projects', [])->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(User::factory()->create());

        $this->post('/projects', [])->assertSessionHasErrors('description');
    }
    /** @test */
    public function guests_cannot_control_projects()
    {
        $project = Project::factory()->create();

        $this->post('/projects', [$project->toArray()])->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }
}
