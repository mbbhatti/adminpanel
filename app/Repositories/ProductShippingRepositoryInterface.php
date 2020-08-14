<?php

namespace App\Repositories;

interface ProductShippingRepositoryInterface
{
    /**
     * Create | Update product Shipping.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveProductShipping(object $request): int;
}

