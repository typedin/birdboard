<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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
}
