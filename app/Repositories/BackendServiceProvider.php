<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\RoleRepositoryInterface',
            'App\Repositories\RoleRepository'
        );
        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\UserRoleRepositoryInterface',
            'App\Repositories\UserRoleRepository'
        );
        $this->app->bind(
            'App\Repositories\PageRepositoryInterface',
            'App\Repositories\PageRepository'
        );
        $this->app->bind(
            'App\Repositories\MenuRepositoryInterface',
            'App\Repositories\MenuRepository'
        );
        $this->app->bind(
            'App\Repositories\MenuItemRepositoryInterface',
            'App\Repositories\MenuItemRepository'
        );
        $this->app->bind(
            'App\Repositories\SettingRepositoryInterface',
            'App\Repositories\SettingRepository'
        );
        $this->app->bind(
            'App\Repositories\PostRepositoryInterface',
            'App\Repositories\PostRepository'
        );
        $this->app->bind(
            'App\Repositories\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );
        $this->app->bind(
            'App\Repositories\ProductShippingRepositoryInterface',
            'App\Repositories\ProductShippingRepository'
        );
        $this->app->bind(
            'App\Repositories\ProductPriceRepositoryInterface',
            'App\Repositories\ProductPriceRepository'
        );
        $this->app->bind(
            'App\Repositories\ProductInventoryRepositoryInterface',
            'App\Repositories\ProductInventoryRepository'
        );
        $this->app->bind(
            'App\Repositories\UserPlaceRepositoryInterface',
            'App\Repositories\UserPlaceRepository'
        );
        $this->app->bind(
            'App\Repositories\BannerRepositoryInterface',
            'App\Repositories\BannerRepository'
        );
    }
}

