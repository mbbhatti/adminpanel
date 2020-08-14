<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * @var MenuRepository
     */
    protected $menu;

    /**
     * MenuController constructor.
     *
     * @param MenuRepository $menu
     */
    public function __construct(MenuRepository $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Show menu list.
     *
     * @return View
     */
    public function list()
    {
        $menus = $this->menu->getAllMenus();
        $keys = empty($menus) ? [] : array_keys($menus[0]);

        return view('Admin\Menu\list', [
            'menus' => $menus,
            'keys' => $keys
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
            'name' =>  'required|string|unique:menus,name,'.$id.',id'
        ];

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
        $route = 'admin/menus/create';
        if (isset($id)) {
            $route = 'admin/menus/'. $id . '/edit';
        }

        // Check post request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {
            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $this->menu->saveMenu($request);
            }

            return redirect('admin/menus');
        }

        $menu = [];
        if (isset($id)) {
            $menu = $this->menu->getMenuById($id);
        }

        return view('Admin\Menu\edit-add', [
            'menu' => $menu,
            'id' => $id,
            'route' => $route
        ]);
    }

    /**
     * Delete menu.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        if ($this->menu->deleteMenu($id)) {
            return redirect('admin/menus');
        }

        return redirect('admin/menus')->withErrors(['Menus does not exist.']);
    }
}

