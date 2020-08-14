<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const PUBLISHED = 'PUBLISHED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'seo_title',
        'excerpt',
        'body',
        'slug',
    ];
}

