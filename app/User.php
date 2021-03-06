<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all projects owned by the user,
     * ordered by the last time they were edited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class, "owner_id")->latest('updated_at');
    }

    /**
     * Get all projects a user has access to.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function accessibleProjects(): Collection
    {
        return Project::where("owner_id", $this->id)
            ->orWhereHas("members", function ($query) {
                $query->where("user_id", $this->id);
            })
            ->get();
    }
}
