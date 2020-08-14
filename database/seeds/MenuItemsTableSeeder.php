<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Dashboard',
                'url_type' => 'Route',
                'route' => 'dashboard',
                'menu_id' => 1,
                'order' => 1,
                'parent_id' => 0,
                'icon' => 'boat'
            ], [
                'title' => 'Posts',
                'url_type' => 'Route',
                'route' => 'posts',
                'menu_id' => 1,
                'order' => 2,
                'parent_id' => 0,
                'icon' => 'news'
            ], [
                'title' => 'Media',
                'url_type' => 'Route',
                'route' => 'media',
                'menu_id' => 1,
                'order' => 3,
                'parent_id' => 0,
                'icon' => 'images'
            ], [
                'title' => 'Pages',
                'url_type' => 'Route',
                'route' => 'pages',
                'menu_id' => 1,
                'order' => 4,
                'parent_id' => 0,
                'icon' => 'file-text'
            ], [
                'title' => 'Menus',
                'url_type' => 'Route',
                'route' => 'menus',
                'menu_id' => 1,
                'order' => 5,
                'parent_id' => 0,
                'icon' => 'list'
            ], [
                'title' => 'Categories',
                'url_type' => 'Route',
                'route' => 'categories',
                'menu_id' => 1,
                'order' => 6,
                'parent_id' => 0,
                'icon' => 'categories'
            ], [
                'title' => 'Authentication',
                'url_type' => '',
                'route' => null,
                'menu_id' => 1,
                'order' => 7,
                'parent_id' => 0,
                'icon' => 'tools'
            ], [
                'title' => 'Users',
                'url_type' => 'Route',
                'route' => 'users',
                'menu_id' => 1,
                'order' => 1,
                'parent_id' => 7,
                'icon' => 'person'
            ], [
                'title' => 'Roles',
                'url_type' => 'Route',
                'route' => 'roles',
                'menu_id' => 1,
                'order' => 2,
                'parent_id' => 7,
                'icon' => 'lock'
            ], [
                'title' => 'Settings',
                'url_type' => '',
                'route' => null,
                'menu_id' => 1,
                'order' => 8,
                'parent_id' => 0,
                'icon' => 'settings'
            ], [
                'title' => 'General',
                'url_type' => 'Route',
                'route' => 'settings',
                'menu_id' => 1,
                'order' => 1,
                'parent_id' => 10,
                'icon' => 'settings'
            ], [
                'title' => 'Mail',
                'url_type' => 'Route',
                'route' => 'mail',
                'menu_id' => 1,
                'order' => 2,
                'parent_id' => 10,
                'icon' => 'mail'
            ], [
                'title' => 'Banner',
                'url_type' => 'Route',
                'route' => 'banners',
                'menu_id' => 1,
                'order' => 3,
                'parent_id' => 10,
                'icon' => 'images'
            ], [
                'title' => 'Calendar',
                'url_type' => 'Route',
                'route' => 'calendar',
                'menu_id' => 1,
                'order' => 4,
                'parent_id' => 10,
                'icon' => 'calendar'
            ], [
                'title' => 'Products',
                'url_type' => 'Route',
                'route' => 'products',
                'menu_id' => 1,
                'order' => 9,
                'parent_id' => 0,
                'icon' => 'basket'
            ]
        ];

        DB::table('menu_items')->insert($data);
    }
}

