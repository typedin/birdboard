<?php

namespace Tests\Model;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_have_projects()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /**
     * @test
     */
    public function a_user_has_accessible_projects()
    {
        $john = factory(User::class)->create();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $saly = factory(User::class)->create();
        $nick = factory(User::class)->create();

        $sallysProject = tap(ProjectFactory::ownedBy($saly)->create())->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $sallysProject->invite($john);
        $this->assertCount(2, $john->accessibleProjects());
    }
}
