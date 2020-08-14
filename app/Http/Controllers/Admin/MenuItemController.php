<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use App\Repositories\MenuItemRepository;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class MenuItemController extends Controller
{
    /**
     * @var MenuRepository
     */
    protected $menu;

    /**
     * @var MenuItemRepository
     */
    protected $menuItem;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * MenuController constructor.
     *
     * @param MenuRepository $menu
     * @param MenuItemRepository $menuItem
     * @param Helper $helper
     */
    public function __construct(MenuRepository $menu, MenuItemRepository $menuItem, Helper $helper)
    {
        $this->menu = $menu;
        $this->menuItem = $menuItem;
        $this->helper = $helper;
    }

    /**
     * Show menu item list.
     *
     * @param Request $menu
     * @return View
     */
    public function list($menu)
    {
        $child = $this->helper->getMenuList($menu);
        $menu = $this->menu->getMenuById($menu);

        return view('Admin\Menu\builder', [
            'menu' => $menu,
            'child' => $child,
        ]);
    }

    /**
     * Validate incoming request.
     *
     * @param  array  $data use for request data
     * @param  int  $id     use for entity id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id)
    {
        $rules = [
            'title' =>  'required|string|unique:menu_items,title,'.$id.',id',
            'url_type' =>  'required'
        ];

        if (strtolower($data['url_type']) == 'route') {
            $rules['route'] = 'required|string';
        }

        if (strtolower($data['url_type']) == 'url') {
            $rules['url'] = 'required|string';
        }

        return Validator::make($data, $rules);
    }

    /**
     * UpdateOrNew page.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        $id = request('id');
        $menu = request('menu');
        $route = 'admin/menus/'.$menu.'/item/create';
        if (isset($id)) {
            $route = 'admin/menus/'.$menu.'/item/'. $id . '/edit';
        }

        // Check post request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {
            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $this->menuItem->saveMenuItem($request, $menu);
            }

            return redirect('admin/menus');
        }

        $menu = [];
        if (isset($id)) {
            $menu = $this->menuItem->getMenuItemById($id);
        }
        $types = [
            'Route' => 'Dynamic Route',
            'URL' => 'Static Url'
        ];

        return view('Admin\SubMenu\edit-add', [
            'menu' => $menu,
            'types' => $types,
            'id' => $id,
            'route' => $route
        ]);
    }

    /**
     * Delete menu.
     *
     * @param $menu
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function delete($menu, $id)
    {
        if ($this->menuItem->deleteMenuItem($menu, $id)) {
            return redirect('admin/menus');
        }

        return redirect('admin/menus')->withErrors(['Menu item does not exist.']);
    }

    /**
     * Order menu items
     *
     * @param Request $request
     */
    public function orderItem(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));
        $this->menuItem->orderMenu($menuItemOrder, null);
    }
}

