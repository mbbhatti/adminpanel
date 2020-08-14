<?php

namespace App\Repositories;

use App\MenuItem;

class MenuItemRepository implements MenuItemRepositoryInterface
{
    /**
     * Get menu item list.
     *
     * @param int $menuId
     * @return array
     */
    public function getAllMenuItems(int $menuId): array
    {
        return MenuItem::select(
            'id',
            'title',
            'url_type',
            'url',
            'route',
            'parent_id',
            'icon'
        )
            ->orderBy('parent_id', 'ASC')
            ->orderBy('order', 'ASC')
            ->where('menu_id', $menuId)
            ->get()
            ->toArray();
    }

    /**
     * Get menu item by id.
     *
     * @param int $id
     * @return object
     */
    public function getMenuItemById(int $id): object
    {
        return MenuItem::select(
            'id',
            'menu_id',
            'url_type',
            'title',
            'url',
            'route',
            'icon'
        )
            ->where('id', $id)
            ->first();
    }

    /**
     * Create | Update menu item.
     *
     * @param object $request
     * @param int $menuId
     * @return int
     */
    public function saveMenuItem(object $request, int $menuId): int
    {
        $order = MenuItem::max('order');
        $id = request('id');
        $menuItem = MenuItem::firstOrNew(['id' => $id]);
        $menuItem->menu_id = $menuId;
        $menuItem->title = $request->input('title');
        $url_type = $request->input('url_type');
        if (strtolower($url_type) == 'route') {
            $menuItem->route = $request->input('route');
            $menuItem->url = null;
        } else {
            $menuItem->url = $request->input('url');
            $menuItem->route = null;
        }
        $menuItem->url_type = $url_type;
        $menuItem->parent_id = 0;
        if (!isset($id)) {
            $menuItem->order = $order + 1;
        }
        $menuItem->icon = $request->input('icon') ?? null;
        $menuItem->save();

        return $menuItem->id;
    }

    /**
     * Delete menu item.
     *
     * @param int $menuId
     * @param int $id
     * @return bool
     */
    public function deleteMenuItem(int $menuId, int $id): bool
    {
        return MenuItem::where('id', $id)->where('menu_id', $menuId)->delete();
    }

    /**
     * Set menu item order by ajax
     *
     * @param array $menuItems
     * @param int $parentId
     */
    public function orderMenu(array $menuItems, int $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}

