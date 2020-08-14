<?php

namespace App\Repositories;

interface ProductPriceRepositoryInterface
{
    /**
     * Create | Update product price.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveProductPrice(object $request): int;
}

