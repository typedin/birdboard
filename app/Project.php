<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * @var array
     */
    public array $oldAttributes;

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
     * Record activity for a project.
     *
     * @param string $description
     * @return void
     */
    public function recordActivity(string $description): void
    {
        $this->activity()->create([
            "description" => $description,
            "changes" => $this->activityChanges($description),
        ]);
    }

    /**
     * Track the changes.
     *
     * @param string $description
     * @return arra
     */
    private function activityChanges(string $description): array
    {
        $changes = [];

        if ($description === "updated") {
            $changes = [
                "before" => $this->before(),
                "after" => $this->getChanges()
            ];
        }

        return $changes;
    }

    /**
     * Create the before data.
     *
     * @return array
     */
    private function before(): array
    {
        return array_diff(
            $this->withoutTimestamps($this->oldAttributes),
            $this->withoutTimestamps($this->getAttributes())
        );
    }

    /**
     * Strip out timestamps.
     *
     * @param array $attributes
     * @return array
     */
    private function withoutTimestamps(array $attributes): array
    {
        $tmp = $attributes;
        foreach (["created_at", "updated_at"] as $keyToRemove) {
            unset($tmp[$keyToRemove]);
        }
        return $tmp;
    }
}
