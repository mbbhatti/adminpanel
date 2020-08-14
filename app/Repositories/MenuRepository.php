<?php

namespace App\Repositories;

use App\Menu;

class MenuRepository implements MenuRepositoryInterface
{
    /**
     * Get menu list.
     *
     * @return array
     */
    public function getAllMenus(): array
    {
        return Menu::select('id', 'name')
            ->orderBy('id', 'ASC')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get menu by id.
     *
     * @param int $id
     * @return object
     */
    public function getMenuById(int $id): object
    {
        return Menu::select('id', 'name')->where('id', $id)->first();
    }

    /**
     * Create | Update menu.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveMenu(object $request): int
    {
        $menu = Menu::firstOrNew(['id' => request('id')]);
        $menu->name = $request->input('name');
        $menu->save();

        return $menu->id;
    }

    /**
     * Delete menu.
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenu(int $id): bool
    {
        return Menu::where('id', $id)->delete();
    }
}

