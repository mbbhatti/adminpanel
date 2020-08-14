<?php

namespace App\Repositories;

use App\User;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    /**
     * Create | Update Role.
     *
     * @param array $roles
     * @param int $userId
     * @return array
     */
    public function saveUserRoles(array $roles, int $userId): array
    {
        return User::find($userId)->roles()->sync($roles);
    }

    /**
     * Delete a user roles.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUserRole(int $userId): bool
    {
        return User::find($userId)->roles()->detach();
    }

    /**
     * Delete all user roles expect logged In.
     *
     * @param array $users
     * @return bool
     */
    public function deleteAllUserRoles(array $users): bool
    {
        foreach ($users as $user) {
            return User::find($user)->roles()->detach();
        }
    }
}

