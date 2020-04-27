<?php

namespace App;

/**
 * Trait RecordActivityTrait
 */
trait RecordActivityTrait
{
    /**
     * The model's old attributes.
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootRecordActivityTrait()
    {
        foreach (self::recordableEvents() as $eventType) {
            static::$eventType(function ($model) use ($eventType) {
                $model->recordActivity($model->activityDescription($eventType));
            });
            
            if ($eventType === "updated") {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }
    
    /**
     * Get the description of the activity.
     *
     * @param string $eventType
     * @return string $description
     */
    protected function activityDescription($eventType)
    {
        return "{$eventType}_" . strtolower(class_basename($this));
    }

    /**
     * Fetch the model events that should trigger activity.
     *
     * @return array
     */
    protected static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }

        return ["created", "updated", "deleted"];
    }

    /**
     * The activity feed for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany Activity
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, "subject")->latest();
    }

    /**
     * Record activity for the model.
     *
     * @param string $description
     * @return void
     */
    public function recordActivity(string $description): void
    {
        $this->activity()->create([
            "description" => $description,
            "changes" => $this->activityChanges(),
            "project_id" => class_basename($this) === "Project" ? $this->id : $this->project->id,
        ]);
    }

    /**
     * Track the changes.
     *
     * @return array
     */
    private function activityChanges(): array
    {
        $changes = [];

        if ($this->wasChanged()) {
            $changes = [
                "before" => array_diff($this->oldAttributes, $this->getAttributes()),
                "after" => $this->getChanges()
            ];
        }

        return $changes;
    }
}
