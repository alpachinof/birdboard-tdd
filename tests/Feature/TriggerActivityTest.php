<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function creating_a_project(): void
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);


        tap($project->activity->last(), function ($activity) {

            $this->assertEquals('created_project', $activity->description);

            $this->assertNull($activity->changes);
        });
    }
    /** * @test */
    public function updating_a_project(): void
    {
        $this->withoutExceptionHandling();
        $project = Project::factory()->create();
        $originalTitle = $project->title;

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }
    /** * @test */
    public function creating_a_new_task(): void
    {
        $project = Project::factory()->create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some task', $activity->subject->body);
        });
    }
    /** * @test */
    public function completing_a_task(): void
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);


        $task = $project->addTask('some task');

        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);


        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }
    /** * @test */
    public function incompleting_a_task(): void
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);


        $task = $project->addTask('some task');

        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);


        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }
    /** * @test */
    public function deleting_a_task(): void
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);


        $task = $project->addTask('some task');

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
