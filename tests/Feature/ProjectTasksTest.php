<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    /** * @test */
    public function guests_cannot_add_tasks_to_projects(): void
    {

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }
    /** * @test */
    public function only_the_owner_of_a_project_may_add_tasks(): void
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }
    /** * @test */
    public function only_the_owner_of_a_project_may_update_a_tasks(): void
    {
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask('test task');

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }
    /** * @test */
    public function tasks_can_be_updated(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = $project->addTask('some task');


        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }
    /** * @test */
    public function a_project_can_have_tasks(): void
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $this->post($project->path() . '/tasks', ['body' => 'lorem ipsum']);

        $this->get($project->path())
            ->assertSee('lorem ipsum');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
