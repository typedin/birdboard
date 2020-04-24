<?php

namespace Tests\Feature;

use App\Project;
use App\User;
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
        $this->get($project->path())->assertRedirect("login");
        $this->post("/projects", $project->toArray())->assertRedirect("login");
    }

    /**
     * @test 
     */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
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

        $this->assertDatabaseHas("projects", $attributes);

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
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory(Project::class)->create(["owner_id" => auth()->id()]);

        $this->patch($project->path(), [ "notes" => "changed" ])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas("projects", [ "notes" => "changed" ]);

        $this->get($project->path())->assertSee("changed");
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $project = factory(Project::class)->create(
            [
            "owner_id" => auth()->id(),
            ]
        );

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /**
     * @test 
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test 
     */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->patch($project->path(), [])->assertStatus(403);
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
