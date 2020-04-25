<?php

namespace App\Observers;

use App\Activity;
use App\Project;
use App\Task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task $task
     * @return void
     */
    public function created(Task $task)
    {
        $this->recordActivity($task->project, "created");
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        if (! $task->completed) {
            return;
        };

        $this->recordActivity($task->project, "updated");
    }

    protected function recordActivity(Project $project, string $activityType): void
    {
        Activity::create(
            [
                "project_id" => $project->id,
                "description" => $activityType
            ]
        );
    }
}
