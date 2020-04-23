<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ["body", "completed"];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path(): string
    {
        return $this->project->path() . '/tasks/' . $this->id;
    }
}
