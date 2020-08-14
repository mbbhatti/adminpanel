<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * UserController constructor.
     *
     * @param UserRepository $user
     * @param RoleRepository $role
     */
    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Show all roles.
     *
     * @return View
     */
    public function list()
    {
        $roles = $this->role->getAllRoles();
        $keys = empty($roles) ? [] : array_keys($roles[0]);

        return view('Admin\Role\list', [
            'roles' => $roles,
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
            'name' =>  'required|string|min:4|unique:roles,name,'.$id.',id',
            'display_name' => 'required|string|min:4',
        ];

        return Validator::make($data, $rules);
    }

    /**
     * UpdateOrNew role.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        $id = request('id');
        $route = 'admin/roles/create';
        if (isset($id)) {
            $route = 'admin/roles/'. $id . '/edit';
        }

        // Check post request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {
            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $this->role->saveRole($request);
            }

            return redirect('admin/roles');
        }

        $role = [];
        if (isset($id)) {
            $role = $this->role->getRoleById($id);
        }

        return view('Admin\Role\edit-add', [
            'role' => $role,
            'id' => $id,
            'route' => $route
        ]);
    }

    /**
     * Delete a role.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        if ($this->role->deleteRole($id)) {
            return redirect('admin/roles');
        }

        return redirect('admin/roles')->withErrors(['Role does not exist.']);
    }

    /**
     * Delete all roles.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function bulkDelete(Request $request)
    {
        $redirectTo = 'admin/roles';
        $ids = $request->get('ids');
        if ($ids === null) {
            return redirect($redirectTo);
        }

        $rows = explode(',', $ids);
        if ($this->role->deleteAllRoles($rows)) {
            return redirect($redirectTo);
        }

        return redirect($redirectTo)->withErrors(['Roles can not be deleted.']);
    }
}

