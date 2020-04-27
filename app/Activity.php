<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $casts = [
        "changes" => "array"
    ];

    /**
     * Attributes to allow fillable assignements.
     *
     * @var array
     */
    protected $fillable = [
        "changes",
        "description",
        "project_id",
        "user_id",
        "subject_id",
        "subject_type",
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
