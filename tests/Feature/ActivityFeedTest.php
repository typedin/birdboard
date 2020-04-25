<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals("created", $project->activity->first()->description);
    }

    /**
     * @test
     */
    public function updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activity);

        $project->update(["title" => "changed"]);
        $project->refresh();

        $this->assertCount(2, $project->activity);
        $this->assertEquals("updated", $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function creating_a_new_task_records_projects_activity()
    {
        $project = ProjectFactory::create();
        $project->addTask("Some task");
        $project->refresh();

        $this->assertCount(2, $project->activity);
        $this->assertEquals("created", $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function completing_a_new_task_records_projects_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $project->refresh();
        $this->assertCount(2, $project->activity);

        $this->actingAs($project->owner)->patch(
            $project->tasks[0]->path(),
            [
            "body" => "foobar",
            "completed" => true
            ]
        );
        $project->refresh();
        $this->assertCount(3, $project->activity);
        $this->assertTrue($project->activity->last()->completed);
    }
}
