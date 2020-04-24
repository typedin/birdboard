<?php

namespace Tests\Setup;

use App\Project;
use App\Task;
use App\User;

/**
 * Class ProjectFactory
 *
 * @author typedin
 */
class ProjectFactory
{
    protected int $taskCount = 0;
    protected User $user;

    public function withTasks(int $taskCount = 0): ProjectFactory
    {
        $this->taskCount = $taskCount;

        return $this;
    }

    public function ownedBy(User $user): ProjectFactory
    {
        $this->user = $user;

        return $this;
    }

    public function create(): Project
    {
        $project = factory(Project::class)->create(
            [
            'owner_id' => $this->user->id ?? factory(User::class)
            ]
        );
        factory(Task::class, $this->taskCount)->create(
            [
            'project_id' => $project->id
            ]
        );

        return $project;
    }
}
