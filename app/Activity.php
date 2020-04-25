<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Attributes to allow fillable assignements.
     *
     * @var array
     */
    protected $fillable = ["project_id", "description"];
}
