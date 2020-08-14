<?php

namespace App\Repositories;

interface RoleRepositoryInterface
{
    /**
     * Get all roles for dropdown option.
     *
     * @return object
     */
    public function getAllRoleOptions(): object;

    /**
     * Get all roles for listing.
     *
     * @return array
     */
    public function getAllRoles(): array;

    /**
     * Get role by id.
     *
     * @param int $roleId
     * @return object
     */
    public function getRoleById(int $roleId): object;

    /**
     * Get all user roles.
     *
     * @param int $userId
     * @return object
     */
    public function getUserRoles(int $userId): object;

    /**
     * Create | Update role.
     *
     * @param  object  $request
     * @return int     last record id
     */
    public function saveRole(object $request): int;

    /**
     * Delete role.
     *
     * @param int $roleId
     * @return bool
     */
    public function deleteRole(int $roleId): bool;

    /**
     * Delete all roles.
     *
     * @param array $roles
     * @return bool
     */
    public function deleteAllRoles(array $roles): bool;
}

