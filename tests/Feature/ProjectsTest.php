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
    public function a_user_can_view_a_project()
    {
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
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
    public function only_authenticated_users_can_create_projects()
    {
        $project = Project::factory()->create();

        $this->post('/projects', [$project])->assertRedirect('login');
    }
}
