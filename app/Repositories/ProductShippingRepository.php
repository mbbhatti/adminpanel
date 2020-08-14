<?php

namespace App\Repositories;

use App\ProductShipping;

class ProductShippingRepository implements ProductShippingRepositoryInterface
{
    /**
     * Create | Update product Shipping.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveProductShipping(object $request): int
    {
        $productShipping = ProductShipping::firstOrNew(['product_id' => request('id')]);
        $productShipping->product_id = request('id');
        $productShipping->weight = $request->input('weight') ?? null;
        $productShipping->width = $request->input('width') ?? null;
        $productShipping->height = $request->input('height') ?? null;
        $productShipping->length = $request->input('length') ?? null;
        $productShipping->save();

        return $productShipping->id;
    }
}

