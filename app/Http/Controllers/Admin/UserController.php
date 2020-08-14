<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRoleRepository;
use App\Repositories\UserPlaceRepository;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class UserController extends Controller
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
     * @var UserRoleRepository
     */
    protected $userRole;

    /**
     * @var UserPlaceRepository
     */
    protected $userPlace;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * UserController constructor.
     *
     * @param UserRepository $user
     * @param RoleRepository $role
     * @param UserRoleRepository $userRole
     * @param UserPlaceRepository $userPlace
     * @param Helper $helper
     */
    public function __construct(
        UserRepository $user,
        RoleRepository $role,
        UserRoleRepository $userRole,
        UserPlaceRepository $userPlace,
        Helper $helper
    )
    {
        $this->user = $user;
        $this->role = $role;
        $this->userRole = $userRole;
        $this->userPlace = $userPlace;
        $this->helper = $helper;
    }

    /**
     * Show user profile.
     *
     * @return View
     */
    public function profile()
    {
        $route = route('user.edit', Auth::user()->getKey());

        return view('Admin\User\profile', compact('route'));
    }

    /**
     * Show all user.
     *
     * @return View
     */
    public function list()
    {
        $users = $this->user->getAll();
        $keys = empty($users) ? [] : array_keys($users[0]);

        return view('Admin\User\list', [
            'users' => $users,
            'keys' => $keys
        ]);
    }

    /**
     * Show user detail.
     *
     * @return View
     */
    public function view()
    {
        $users = $this->user->getAll(request('id'));

        return view('Admin\User\view', [
            'users' => $users[0],
            'id' => $users[0]['id']
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
            'name' => 'required|string|min:3',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:1800',
        ];

        if (isset($id)) {
            $rules['email'] = 'required|string|email|unique:users,email,'.$id.',id';
        } else {
            $rules['email'] = 'required|string|email|unique:users,email';
            $rules['password'] = 'required|between:6,20';
        }

        return Validator::make($data, $rules);
    }

    /**
     * Update user request.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        $id = request('id');
        $route = 'admin/users/create';
        if (isset($id)) {
            $route = 'admin/users/'. $id . '/edit';
        }

        // Check post request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {
            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $filePath = '';
                if ($request->has('avatar')) {
                    // Remove previous avatar
                    if (isset($id)) {
                        $avatar = $this->user->getUserAvatarById($id);
                        if (Storage::disk(config('storage.disk'))->exists($avatar['avatar'])) {
                            Storage::disk(config('storage.disk'))->delete($avatar['avatar']);
                        }
                    }

                    // Upload new avatar
                    $filePath = $this->helper->uploadImage($request->file('avatar'), 'users');
                    if ($filePath == false) {
                        return redirect($route)
                            ->withErrors(['Upload Fail: Unknown error occurred!'])
                            ->withInput();
                    }
                }

                // Add or Update User
                $userId = $this->user->saveUser($request, $filePath);

                // Add or update user place information
                $this->userPlace->saveUserPlace($userId);

                // Add or Update Role
                $this->userRole->saveUserRoles($request->get('role_id'), $userId);
            }

            return redirect('admin/users');
        }

        $user = [];
        $userRoles = [];
        if (isset($id)) {
            $user = $this->user->getUserById($id);
            $userRoles = $this->role->getUserRoles($id);
        }

        // Get all roles
        $roles = $this->role->getAllRoleOptions();

        return view('Admin\User\edit-add', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'id' => $id,
            'route' => $route
        ]);
    }

    /**
     * Delete a user and roles.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        // Delete user roles
        $this->userRole->deleteUserRole($id);

        // Delete user
        if ($this->user->deleteUser($id)) {
            return redirect('admin/users');
        }

        return redirect('admin/users')
            ->withErrors(['User not found.']);
    }

    /**
     * Delete all users and roles.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function bulkDelete(Request $request)
    {
        $redirectTo = 'admin/users';
        $ids = $request->get('ids');
        if ($ids === null) {
            return redirect($redirectTo);
        }

        $rows = explode(',', $ids);
        if ($this->userRole->deleteAllUserRoles($rows) && $this->user->deleteAllUser($rows)) {
            return redirect($redirectTo);
        }

        return redirect($redirectTo)->withErrors(['Something Wrong.']);
    }
}

