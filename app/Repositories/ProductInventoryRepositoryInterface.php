<?php

namespace App\Repositories;

interface ProductInventoryRepositoryInterface
{
    /**
     * Create | Update product Inventory.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveProductInventory(object $request): int;

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions():  array;
}

