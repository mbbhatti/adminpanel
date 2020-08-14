<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Basic Route
Route::get('/', function () {
    return redirect('admin/login');
});

// Admin namespace routes
Route::namespace('Admin')->group(function () {

    // Dashboard
    Route::get('admin/dashboard', 'DashboardController@index')
        ->name('dashboard')
        ->middleware('auth');

    // Upload image
    Route::post('admin/upload', 'UploadController@upload')
        ->name('upload')
        ->middleware('auth');

    // Admin prefix Routes
    Route::prefix('admin')->group(function () {

        // Auth Route
        Route::get('login', 'Auth\LoginController@show')->name('login');
        Route::post('login', 'Auth\LoginController@login')->name('login');
        Route::get('logout', 'Auth\LoginController@logout')->name('logout')
            ->middleware('auth');

        // User Route
        Route::get('users', 'UserController@list')
            ->name('users')
            ->middleware('auth');
        Route::get('profile', 'UserController@profile')
            ->name('profile')
            ->middleware('auth');
        Route::match(['GET','POST'], 'users/create', 'UserController@create')
            ->name('user.create')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'users/{id}/edit', 'UserController@create')
            ->name('user.edit')
            ->middleware('auth');
        Route::delete('users/delete/bulk','UserController@bulkDelete')
            ->name('user.bulk.delete')
            ->middleware('auth');
        Route::delete('users/delete/{id}','UserController@delete')
            ->name('user.delete')
            ->middleware('auth');
        Route::get('users/{id}','UserController@view')
            ->name('user.view')
            ->middleware('auth');

        // Role Route
        Route::get('roles', 'RoleController@list')
            ->name('roles')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'roles/{id}/edit', 'RoleController@create')
            ->name('role.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'roles/create', 'RoleController@create')
            ->name('role.create')
            ->middleware('auth');
        Route::delete('roles/delete/bulk','RoleController@bulkDelete')
            ->name('role.bulk.delete')
            ->middleware('auth');
        Route::delete('roles/delete/{id}','RoleController@delete')
            ->name('role.delete')
            ->middleware('auth');

        // Category Route
        Route::get('categories', 'CategoryController@list')
            ->name('categories')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'categories/{id}/edit', 'CategoryController@create')
            ->name('category.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'categories/create', 'CategoryController@create')
            ->name('category.create')
            ->middleware('auth');
        Route::delete('categories/delete/bulk','CategoryController@bulkDelete')
            ->name('category.bulk.delete')
            ->middleware('auth');
        Route::delete('categories/delete/{id}','CategoryController@delete')
            ->name('category.delete')
            ->middleware('auth');

        // Page Route
        Route::get('pages', 'PageController@list')
            ->name('pages')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'pages/{id}/edit', 'PageController@create')
            ->name('page.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'pages/create', 'PageController@create')
            ->name('page.create')
            ->middleware('auth');
        Route::delete('pages/delete/bulk','PageController@bulkDelete')
            ->name('page.bulk.delete')
            ->middleware('auth');
        Route::delete('pages/delete/{id}','PageController@delete')
            ->name('page.delete')
            ->middleware('auth');

        // Menu Route
        Route::get('menus', 'MenuController@list')
            ->name('menus')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'menus/{id}/edit', 'MenuController@create')
            ->name('menu.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'menus/create', 'MenuController@create')
            ->name('menu.create')
            ->middleware('auth');
        Route::delete('menus/delete/{id}','MenuController@delete')
            ->name('menu.delete')
            ->middleware('auth');

        // Menu Item Route
        Route::get('menus/{menu}/items', 'MenuItemController@list')
            ->name('menu.items')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'menus/{menu}/item/{id}/edit', 'MenuItemController@create')
            ->name('menu.item.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'menus/{menu}/item/create', 'MenuItemController@create')
            ->name('menu.item.create')
            ->middleware('auth');
        Route::delete('menus/{menu}/item/delete/{id}','MenuItemController@delete')
            ->name('menu.item.delete')
            ->middleware('auth');
        Route::post('menus/{menu}/order', 'MenuItemController@orderItem')
            ->name('menu.items.order')
            ->middleware('auth');

        // General Setting Route
        Route::get('settings', 'SettingController@show')
            ->name('settings')
            ->middleware('auth');
        Route::POST('settings/create', 'SettingController@create')
            ->name('settings.create')
            ->middleware('auth');
        Route::match(['PUT'], 'settings/update', 'SettingController@update')
            ->name('settings.update')
            ->middleware('auth');
        Route::get('settings/{id}/move/up', 'SettingController@moveUp')
            ->name('settings.move.up')
            ->middleware('auth');
        Route::get('settings/{id}/move/down', 'SettingController@moveDown')
            ->name('settings.move.down')
            ->middleware('auth');
        Route::delete('settings/{id}/delete', 'SettingController@delete')
            ->name('settings.delete')
            ->middleware('auth');
        Route::match(['put'], 'settings/{id}/delete/value', 'SettingController@deleteValue')
            ->name('settings.delete.value')
            ->middleware('auth');

        // Mail Setting Route
        Route::get('mail', 'MailSettingController@show')
            ->name('mail')
            ->middleware('auth');
        Route::match(['PUT'], 'mail/update', 'MailSettingController@update')
            ->name('mail.update')
            ->middleware('auth');
        Route::post('mail/send', 'MailSettingController@sendEmail')
            ->name('mail.send')
            ->middleware('auth');

        // Media Route
        Route::get('media', 'MediaController@show')
            ->name('media')
            ->middleware('auth');
        Route::group([
            'as'     => 'media.',
            'prefix' => 'media',
        ], function ()  {
            Route::post('files', ['uses' => 'MediaController@files', 'as' => 'files']);
            Route::post('new_folder', ['uses' => 'MediaController@createFolder', 'as' => 'new_folder']);
            Route::post('delete_file_folder', ['uses' => 'MediaController@delete', 'as' => 'delete']);
            Route::post('move_file', ['uses' => 'MediaController@move', 'as' => 'move']);
            Route::post('rename_file', ['uses' => 'MediaController@rename', 'as' => 'rename']);
            Route::post('upload', ['uses' => 'MediaController@upload', 'as' => 'upload']);
            Route::post('crop', ['uses' => 'MediaController@crop', 'as' => 'crop']);
        });

        // Post Route
        Route::get('posts', 'PostController@list')
            ->name('posts')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'posts/{id}/edit', 'PostController@create')
            ->name('post.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'posts/create', 'PostController@create')
            ->name('post.create')
            ->middleware('auth');
        Route::delete('posts/delete/bulk','PostController@bulkDelete')
            ->name('post.bulk.delete')
            ->middleware('auth');
        Route::delete('posts/delete/{id}','PostController@delete')
            ->name('post.delete')
            ->middleware('auth');
        Route::post('posts/remove', 'PostController@remove')
            ->name('post.remove')
            ->middleware('auth');

        // Product Route
        Route::get('products', 'ProductController@list')
            ->name('products')
            ->middleware('auth');
        Route::match(['GET','PUT'], 'products/{id}/edit', 'ProductController@create')
            ->name('product.edit')
            ->middleware('auth');
        Route::match(['GET','POST'], 'products/create', 'ProductController@create')
            ->name('product.create')
            ->middleware('auth');
        Route::delete('products/delete/bulk','ProductController@bulkDelete')
            ->name('product.bulk.delete')
            ->middleware('auth');
        Route::delete('products/delete/{id}','ProductController@delete')
            ->name('product.delete')
            ->middleware('auth');
        Route::post('products/remove', 'ProductController@remove')
            ->name('product.remove')
            ->middleware('auth');

        // Banner Route
        Route::get('banners', 'BannerController@list')
            ->name('banners')
            ->middleware('auth');
        Route::post('banners/create', 'BannerController@create')
            ->name('banner.create')
            ->middleware('auth');

        // Calendar Route
        Route::get('calendar', 'CalendarController@show')
            ->name('calendar')
            ->middleware('auth');
    });
});


