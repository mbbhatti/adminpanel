<?php

namespace App\Repositories;

interface UserRoleRepositoryInterface
{
    /**
     * Create | Update Role.
     *
     * @param array $roles
     * @param int $userId
     * @return array
     */
    public function saveUserRoles(array $roles, int $userId): array;

    /**
     * Delete a user roles.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUserRole(int $userId): bool;

    /**
     * Delete all user roles expect logged In.
     *
     * @param array $users
     * @return bool
     */
    public function deleteAllUserRoles(array $users): bool;
}

