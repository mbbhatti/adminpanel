<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get product price record associated with the product.
     */
    public function productPrice()
    {
        return $this->hasOne('App\ProductPrice');
    }
}

