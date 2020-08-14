<?php

namespace App\Repositories;

use App\ProductInventory;

class ProductInventoryRepository implements ProductInventoryRepositoryInterface
{
    /**
     * Create | Update product Inventory.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveProductInventory(object $request): int
    {
        $productInventory = ProductInventory::firstOrNew(['product_id' => request('id')]);
        $productInventory->product_id = request('id');
        $productInventory->sku = $request->input('sku') ?? null;
        $productInventory->stock_status = $request->input('stock_status') ?? 'In Stock';
        $productInventory->save();

        return $productInventory->id;
    }

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions():  array
    {
        return [
            'In Stock' => 'In Stock',
            'Out of stock' => 'Out of stock',
            'On backorder' => 'On backorder'
        ];
    }
}

