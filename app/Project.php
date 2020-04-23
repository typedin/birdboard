<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ["title", "description", "owner_id"];

    public function path(): string
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(
            [
                "body" => $body,
                // hack for now
                // @see create_tasks migration
                "completed" => false
            ]
        );
    }
}
