<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize a user to update their projects.
     *
     * @param  \App\User    $user
     * @param  \App\Project $project
     * @return bool
     */
    public function update(User $user, Project $project): bool
    {
        return $user->is($project->owner);
    }
}
