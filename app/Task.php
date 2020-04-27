<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordActivityTrait;

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ["project"];

    /**
     * Attributes to allow fillable assignements.
     *
     * @var array
     */
    protected $fillable = ["body", "completed"];

    /**
     * Attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        "completed" => "boolean"
    ];

    protected static $recordableEvents = [
        "created", "deleted"
    ];

    /**
     * Get the owning project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the path to a task.
     *
     * @return string path
     */
    public function path(): string
    {
        return $this->project->path() . '/tasks/' . $this->id;
    }

    /**
     * Mark a task as complete.
     *
     * @return void
     */
    public function complete(): void
    {
        $this->update(["completed" => true]);

        $this->recordActivity("completed_task");
    }

    /**
     * Mark a task as incomplete.
     *
     * @return void
     */
    public function incomplete(): void
    {
        $this->update(["completed" => false]);

        $this->recordActivity("incompleted_task");
    }
}
