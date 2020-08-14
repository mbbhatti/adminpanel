<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return array
     */
    public function getAllProducts(): array;

    /**
     * Get product by id.
     *
     * @param $id
     * @return object
     */
    public function getProductById($id): object;

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions(): array;

    /**
     * Get product image
     *
     * @param int $id
     * @return object
     */
    public function getProductImageById(int $id): object;

    /**
     * Create | Update product.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function saveProduct(object $request, string $filePath): int;

    /**
     * Delete product.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool;

    /**
     * Delete products.
     *
     * @param array $posts
     * @return bool
     */
    public function deleteProducts(array $posts): bool;
}

