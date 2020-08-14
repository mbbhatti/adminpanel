<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories for parent dropdown option.
     *
     * @return object
     */
    public function getParentCategoriesOptions(): object;

    /**
     * Get all categories for listing.
     *
     * @return array
     */
    public function getAllCategories(): array;

    /**
     * Get category by id.
     *
     * @param int $id
     * @return object
     */
    public function getCategoryById(int $id): object;

    /**
     * Create | Update category.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveCategory(object $request): int;

    /**
     * Delete category.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory(int $id): bool;

    /**
     * Delete categories.
     *
     * @param array $categories
     * @return bool
     */
    public function deleteCategories(array $categories): bool;
}

