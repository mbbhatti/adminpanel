<?php

namespace App\Repositories;

use App\ProductPrice;

class ProductPriceRepository implements ProductPriceRepositoryInterface
{
    /**
     * Create | Update product price.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveProductPrice(object $request): int
    {
        $productPrice = ProductPrice::firstOrNew(['product_id' => request('id')]);
        $productPrice->product_id = request('id');
        $productPrice->regular_price = $request->input('regular_price') ?? null;
        $productPrice->sale_price = $request->input('sale_price') ?? null;
        $productPrice->from_date = $request->input('from_date') ?? null;
        $productPrice->to_date = $request->input('to_date') ?? null;
        $productPrice->save();

        return $productPrice->id;
    }
}

