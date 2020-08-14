<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * Get's all users.
     *
     * @param $userId
     * @return array
     */
    public function getAll(int $userId = null): array;

    /**
     * Get a user by Id
     *
     * @param int $userId
     * @return object
     */
    public function getUserById(int $userId): object;

    /**
     * Get user avatar
     *
     * @param int $userId
     * @return object
     */
    public function getUserAvatarById(int $userId): object;

    /**
     * Create | Update User.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function saveUser(object $request, string $filePath): int;

    /**
     * Delete user.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool ;

    /**
     * Delete all users expect logged In.
     *
     * @param array $users
     * @return bool
     */
    public function deleteAllUser(array $users): bool;

    /**
     * Get latest users.
     *
     * @return array
     */
    public function getLatestUsers(): array;
}

