<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create(["owner_id" => auth()->id()]);

        $this->post($project->path() . "/tasks", ["body" => "Project task"]);

        $this->get($project->path())->assertSee("Project task");
    }

    /**
     * @test
     */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory(Task::class)->raw(["body" => ""]);

        $this->post($project->path() . "/tasks", $attributes)
            ->assertSessionHasErrors("body");
    }
}
