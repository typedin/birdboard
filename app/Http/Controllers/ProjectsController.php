<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    /**
     * Show all projects for a user.
     *
     * @return View
     */
    public function index(): View
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact("projects"));
    }

    /**
     * Show a specific project for a user.
     *
     * @param  \App\Project $project
     * @return View
     * @throw  \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project): View
    {
        $this->authorize("update", $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the page to create a project.
     *
     * @return View
     */
    public function create(): View
    {
        return view("projects.create");
    }

    /**
     * Persist a new project.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    /**
     * Show the page to edit a project.
     *
     * @param  \App\Project $project
     * @return View
     */
    public function edit(Project $project): View
    {
        return view("projects.edit", compact('project'));
    }

    /**
     * Update the project.
     *
     * @param  \App\Project $project
     * @return RedirectResponse
     * @throw  \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project): RedirectResponse
    {
        $this->authorize("update", $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    /**
     * Validate the request for a project.
     *
     * @return array validated data
     */
    protected function validateRequest(): array
    {
        return request()->validate(
            [
                "title" => "required",
                "description" => "required",
                "notes" => "min:3",
            ]
        );
    }
}
