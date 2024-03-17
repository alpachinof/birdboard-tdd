<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function it_has_a_path(): void
    {
        $project = Project::factory()->create();

        $this->assertEquals('projects' . $project->id, $project->path());
    }
}
