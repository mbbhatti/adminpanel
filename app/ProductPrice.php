<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regular_price',
    ];

    /**
     * Get the product that owns the price.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

