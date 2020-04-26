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

    /**
     * Add tasks to a project.
     *
     * @param int $taskCount (optional)
     * @return ProjectFactory
     */
    public function withTasks(int $taskCount = 0): ProjectFactory
    {
        $this->taskCount = $taskCount;

        return $this;
    }

    /**
     * Assign an owner to a project.
     *
     * @param \App\User $user
     * @return ProjectFactory
     */
    public function ownedBy(User $user): ProjectFactory
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Create a project.
     *
     * @return Project
     *
     */
    public function create(): Project
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id ?? factory(User::class)
        ]);
        factory(Task::class, $this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
