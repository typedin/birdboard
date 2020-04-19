<?php

namespace Tests\Model;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test 
     */
    public function it_has_a_path()
    {
        $project = factory(Project::class)->create();

        $this->assertEquals(
            '/projects/1',
            $project->path()
        );
    }
}
