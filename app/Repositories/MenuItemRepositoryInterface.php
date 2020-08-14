<?php

namespace App\Repositories;

interface MenuItemRepositoryInterface
{
    /**
     * Get menu item list.
     *
     * @param int $menuId
     * @return array
     */
    public function getAllMenuItems(int $menuId): array;

    /**
     * Get menu item by id.
     *
     * @param int $id
     * @return object
     */
    public function getMenuItemById(int $id): object;

    /**
     * Create | Update menu item.
     *
     * @param object $request
     * @param int $menuId
     * @return int
     */
    public function saveMenuItem(object $request, int $menuId): int;

    /**
     * Delete menu item.
     *
     * @param int $menuId
     * @param int $id
     * @return bool
     */
    public function deleteMenuItem(int $menuId, int $id): bool;

    /**
     * Set menu item order by ajax
     *
     * @param array $menuItems
     * @param int $parentId
     */
    public function orderMenu(array $menuItems, int $parentId);
}

