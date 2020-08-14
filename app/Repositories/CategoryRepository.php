<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories for parent dropdown option.
     *
     * @return object
     */
    public function getParentCategoriesOptions(): object
    {
        return Category::pluck('name', 'id');
    }

    /**
     * Get all categories for listing.
     *
     * @return array
     */
    public function getAllCategories(): array
    {
        return Category::select('id', 'order','name', 'slug')
            ->orderBy('categories.id', 'ASC')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get category by id.
     *
     * @param int $id
     * @return object
     */
    public function getCategoryById(int $id): object
    {
        return Category::select('id', 'parent_id' ,'order','name', 'slug')
            ->where('id', $id)
            ->first();
    }

    /**
     * Create | Update category.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveCategory(object $request): int
    {
        $category = Category::firstOrNew(['id' => request('id')]);
        $category->order = $request->input('order');
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $parentId = $request->input('parent');
        if (isset($parentId)) {
            $category->parent_id = $parentId;
        }
        $category->save();

        return $category->id;
    }

    /**
     * Delete category.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory(int $id): bool
    {
        return Category::where('id', $id)->delete();
    }

    /**
     * Delete categories.
     *
     * @param array $categories
     * @return bool
     */
    public function deleteCategories(array $categories): bool
    {
        return Category::whereIn('id', $categories)->delete();
    }
}

