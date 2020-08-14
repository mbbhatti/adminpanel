<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
    ];

    /**
     * Relationship with User
     * Many to Many
     *
     * @return object
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

