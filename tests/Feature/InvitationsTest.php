<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $assertActionIsForbidden = fn () => $this->actingAs($user)
                 ->post($project->path() . "/invitations", [])
                 ->assertStatus(403);

        $assertActionIsForbidden();

        $project->invite($user);

        $assertActionIsForbidden();
    }


    /**
     * @test
     */
    public function a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();
        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)
             ->post($project->path() . "/invitations", [
                 "email" => $userToInvite->email
             ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /**
     * @test
     */
    public function the_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();

        $response = $this->actingAs($project->owner)
                         ->post($project->path() . "/invitations", [
                             "email" => "notauser@example.com"
                         ]);

        $response->assertSessionHasErrors(
            ["email" => "The user you are inviting must have a Birdboard account."],
            null, // format
            "invitations" // error bag
        );
    }

    /**
     * @test
     */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);
        $this->post(action("ProjectTasksController@store", $project), $task = [ "body" => "Foo task" ]);

        $this->assertDatabaseHas("tasks", $task);
    }
}
