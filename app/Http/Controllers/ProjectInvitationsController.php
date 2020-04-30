<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Project;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{
    /**
     * Invite a new user to a project.
     *
     * @param \App\Project $project
     * @param \App\Http\Requests\ProjectInvitationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Project $project, ProjectInvitationRequest $request): RedirectResponse
    {
        $project->invite(User::whereEmail(request("email"))->firstOrFail());

        return redirect($project->path());
    }
}
