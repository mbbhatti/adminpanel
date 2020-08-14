<?php

namespace App\Repositories;

use App\Role;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Get all roles for dropdown option.
     *
     * @return object
     */
    public function getAllRoleOptions(): object
    {
        return Role::pluck('display_name', 'id');
    }

    /**
     * Get all roles for listing.
     *
     * @return array
     */
    public function getAllRoles(): array
    {
        return Role::select('id', 'name', 'display_name')
            ->orderBy('roles.id', 'ASC')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get role by id.
     *
     * @param int $roleId
     * @return object
     */
    public function getRoleById(int $roleId): object
    {
        return Role::select('id', 'name', 'display_name')
            ->where('id', $roleId)
            ->first();
    }

    /**
     * Get all user roles.
     *
     * @param int $userId
     * @return object
     */
    public function getUserRoles(int $userId): object
    {
        return Role::leftJoin('role_user', 'role_user.role_id', '=', 'roles.id')
            ->orderBy('role_user.role_id', 'ASC')
            ->where('role_user.user_id', $userId)
            ->pluck('id');
    }

    /**
     * Create | Update role.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveRole(object $request): int
    {
        $role = Role::firstOrNew(['id' => request('id')]);
        $role->name = strtolower($request->input('name'));
        $role->display_name = $request->input('display_name');
        $role->save();

        return $role->id;
    }

    /**
     * Delete role.
     *
     * @param int $roleId
     * @return bool
     */
    public function deleteRole(int $roleId): bool
    {
        return Role::where('id', $roleId)->delete();
    }

    /**
     * Delete all roles.
     *
     * @param array $roles
     * @return bool
     */
    public function deleteAllRoles(array $roles): bool
    {
        return Role::whereIn('id', $roles)->delete();
    }
}

