<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    /** @test */
    public function a_user_can_create_a_project(): void
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }
}
