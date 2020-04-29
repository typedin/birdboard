<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordActivityTrait;

    /**
     * Attributes to allow fillable assignements.
     *
     * @var array
     */
    protected $fillable = [
        "description",
        "notes",
        "owner_id",
        "title",
    ];

    /**
     * The path to a project.
     *
     * @return string path
     */
    public function path(): string
    {
        return "/projects/{$this->id}";
    }

    /**
     * The owner of the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo User
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The task associated to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Task
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * The pieces of activity associated to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Activity
     */
    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * Add a task to a project.
     *
     * @param  string $body
     * @return \Illuminate\Database\Eloquent\Model Task
     */
    public function addTask(string $body)
    {
        return $this->tasks()->create([
            "body" => $body,
            "completed" => false
        ]);
    }

    /**
     * Invite user to a project.
     *
     * @param User $user
     * @return void
     */
    public function invite(User $user): void
    {
        $this->members()->attach($user);
    }

    /**
     * The members associated to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany User
     */
    public function members()
    {
        return $this->belongsToMany(User::class, "project_members")->withTimestamps();
    }
}
