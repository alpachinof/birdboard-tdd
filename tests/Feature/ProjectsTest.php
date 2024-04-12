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
    public function tasks_can_be_included_as_part_of_a_new_project_creation(): void
    {
        $this->signIn();

        $attributes = Project::factory()->raw();

        $attributes['tasks'] = [
            ['body' => 'task 1'],
            ['body' => 'task 2']
        ];

        $this->post('/projects', $attributes);


        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    public function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $user = User::factory()->create();

        $this->signIn($user);

        $project = Project::factory()->create();

        $project->invite($user);

        $this->get('/projects')->assertSee($project->title);
    }
    /** @test */
    public function unauthorized_cannot_delete_projects(): void
    {
        $project = Project::factory()->create();

        $this->delete($project->path())->assertRedirect('/login');

        $user = User::factory()->create();

        $this->signIn($user);

        $this->delete($project->path())->assertStatus(403);


        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }
    /** @test */
    public function a_user_can_delete_a_project(): void
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', [$project->only('id')]);
    }
    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->patch($project->path(), $attributes = [
            'notes' => 'changed',
            'description' => 'something',
            'title' => 'changed'
        ])->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_project_general_notes()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->patch($project->path(), $attributes = [
            'notes' => 'changed',
        ])->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
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
