<?php

namespace App\Repositories;

interface UserPlaceRepositoryInterface
{
    /**
     * Get user locations
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Create | Update user place information.
     *
     * @param int $userId
     * @return int|null
     */
    public function saveUserPlace(int $userId): ?int;
}

