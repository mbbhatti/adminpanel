<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductShipping extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weight',
        'width',
        'length',
        'height',
    ];
}

