<?php

namespace Tests\Model;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_defaults_to_not_completed_when_created()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);
    }

    /**
     * @test
     */
    public function it_belongs_to_a_project()
    {
        $task = factory(Task::class)->create();
        
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /**
     * @test
     */
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals(
            '/projects/' . $task->project->id . '/tasks/' . $task->id,
            $task->path()
        );
    }
}
