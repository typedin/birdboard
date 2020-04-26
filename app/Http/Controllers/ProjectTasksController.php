<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    /**
     * Add a task associated a project.
     *
     * @param  \App\Project $project
     * @return RedirectResponse
     */
    public function store(Project $project): RedirectResponse
    {
        $this->authorize("update", $project);

        request()->validate(["body" => "required"]);

        $project->addTask(request("body"));

        return redirect($project->path());
    }

    /**
     * Update a task.
     *
     * @param  \App\Project $project
     * @param  \App\Task    $task
     * @return RedirectResponse
     * @throw  \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project, Task $task): RedirectResponse
    {
        $this->authorize("update", $task->project);

        request()->validate([
            "body" => "required",
        ]);

        $task->update([
            'body' => request()->input('body')
        ]);

        if (request()->has("completed")) {
            $task->complete();
        }

        return redirect($project->fresh()->path());
    }
}
