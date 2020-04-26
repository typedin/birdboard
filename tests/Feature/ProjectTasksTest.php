<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_add_tasks_to_project()
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . "/tasks", ["body" => "Project task"])
            ->assertRedirect("login");
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create();

        $this->post($project->path() . "/tasks", ["body" => "Project task"])
            ->assertStatus(403);
        $this->assertDatabaseMissing("tasks", ["body" => "Project task"]);
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), ["body" => "changed"])
            ->assertStatus(403);
        $this->assertDatabaseMissing("tasks", ["body" => "changed"]);
    }

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . "/tasks", ["body" => "Project task"]);

        $this->get($project->path())->assertSee("Project task");
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->actingAs($project->owner)->patch($project->tasks->first()->path(), [
            "body" => "changed",
        ]);

        $this->assertDatabaseHas('tasks', [
            "body" => "changed",
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->actingAs($project->owner)->patch($project->tasks->first()->path(), [
            "body" => "changed",
            "completed" => true
        ]);

        $this->assertDatabaseHas('tasks', [
            "body" => "changed",
            "completed" => true
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_marked_as_incompleted()
    {
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->actingAs($project->owner)->patch($project->tasks->first()->path(), [
            "body" => "changed",
            "completed" => true
        ]);

        $this->patch($project->tasks->first()->path(), [
            "body" => "changed",
            "completed" => false
        ]);

        $this->assertDatabaseHas('tasks', [
            "body" => "changed",
            "completed" => false
        ]);
    }

    /**
     * @test
     */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $attributes = factory(Task::class)->raw(["body" => ""]);

        $this->actingAs($project->owner)
            ->post($project->path() . "/tasks", $attributes)
            ->assertSessionHasErrors("body");
    }
}
