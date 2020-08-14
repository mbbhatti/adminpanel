<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
    ];
}

