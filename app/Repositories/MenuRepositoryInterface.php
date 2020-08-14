<?php

namespace App\Repositories;

interface MenuRepositoryInterface
{
    /**
     * Get menu list.
     *
     * @return array
     */
    public function getAllMenus(): array;

    /**
     * Get menu by id.
     *
     * @param int $id
     * @return object
     */
    public function getMenuById(int $id): object;

    /**
     * Create | Update menu.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveMenu(object $request): int;

    /**
     * Delete menu.
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenu(int $id): bool;
}

