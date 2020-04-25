<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_manage_projects()
    {
        $project = factory(Project::class)->create();

        $this->get("/projects")->assertRedirect("login");
        $this->get("/projects/create")->assertRedirect("login");
        $this->get($project->path() . "/edit")->assertRedirect("login");
        $this->get($project->path())->assertRedirect("login");
        $this->post("/projects", $project->toArray())->assertRedirect("login");
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get("/project/create")->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post("/projects", $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes["title"])
            ->assertSee($attributes["description"])
            ->assertSee($attributes["notes"]);
    }
    
    /**
     * @test
     */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();
        $attributes = [
            "title" => "changed",
            "description" => "changed",
            "notes" => "changed",
        ];

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes)
            ->assertRedirect($project->path());
        $this->actingAs($project->owner)->get($project->path() . "/edit")->assertOk();

        $this->assertDatabaseHas("projects", $attributes);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();
        $attributes = ["notes" => "changed"];

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes);
        
        $this->assertDatabaseHas("projects", $attributes);
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $response = $this->actingAs($project->owner)->get($project->path());

        $response->assertSee($project->title)->assertSee($project->description);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $this->patch($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(
            [
            'title' => '',
            ]
        );
        $this->post("/projects", $attributes)->assertSessionHasErrors("title");
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw(
            [
            'description' => '',
            ]
        );

        $this->post("/projects", $attributes)->assertSessionHasErrors("description");
    }
}
