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
}
