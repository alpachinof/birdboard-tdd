<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_a_user()
    {
        $user = $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->assertEquals(auth()->user()->id, $project->activity->first()->user->id);
    }
}
