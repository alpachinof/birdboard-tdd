<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function creating_a_project_records_activity(): void
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('created', $project->activity[0]->description);
    }
    /** * @test */
    public function updating_a_project_records_activity(): void
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);


        $this->assertEquals('updated', $project->activity->last()->description);
    }
    /** * @test */
    public function creating_a_new_task_records_project_activity(): void
    {
        $project = Project::factory()->create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activity);

        $this->assertEquals('created_task', $project->activity->last()->description);
    }
    /** * @test */
    public function creating_a_task_records_project_activity(): void
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);


        $task = $project->addTask('some task');

        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);

        $this->assertEquals('completed_task', $project->activity->last()->description);
    }
}
