<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task $task
     * @return void
     */
    public function created(Task $task): void
    {
        $task->project->recordActivity("created_task");
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task $task
     * @return void
     */
    public function updated(Task $task): void
    {
        if (! $task->completed) {
            return;
        };

        $task->project->recordActivity("completed_task");
    }
}
