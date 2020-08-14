<?php

namespace App\Repositories;

interface BannerRepositoryInterface
{
    /**
     * Get all banners
     *
     * @return object
     */
    public function getAll(): ?object;

    /**
     * Create | Update banner.
     *
     * @param object $request
     * @return bool
     */
    public function saveBanner(object $request): bool;
}

