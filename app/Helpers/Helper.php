<?php

namespace App\Helpers;

use App\Helpers\ContentTypes\Checkbox;
use App\Helpers\ContentTypes\Coordinates;
use App\Helpers\ContentTypes\File;
use App\Helpers\ContentTypes\Image as ContentImage;
use App\Helpers\ContentTypes\MultipleCheckbox;
use App\Helpers\ContentTypes\MultipleImage;
use App\Helpers\ContentTypes\Password;
use App\Helpers\ContentTypes\Relationship;
use App\Helpers\ContentTypes\SelectMultiple;
use App\Helpers\ContentTypes\Text;
use App\Helpers\ContentTypes\Timestamp;
use App\Repositories\MenuItemRepository;
use App\Repositories\MenuRepository;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class Helper
{
    /**
     * @var MenuRepository
     */
    protected $menu;

    /**
     * @var MenuItemRepository
     */
    protected $menuItem;

    /**
     * MenuController constructor.
     *
     * @param MenuRepository $menu
     * @param MenuItemRepository $menuItem
     */
    public function __construct(MenuRepository $menu, MenuItemRepository $menuItem)
    {
        $this->menu = $menu;
        $this->menuItem = $menuItem;
    }

    /**
     * Get menu parent and child
     *
     * @param $menuId
     * @return string
     */
    public function getMenuList($menuId): string
    {
        $menus = $this->menuItem->getAllMenuItems($menuId);
        $menu = [];
        foreach ($menus as $item) {
            $menu['items'][$item['id']] = $item;
            $menu['parents'][$item['parent_id']][] = $item['id'];
        }

        return substr($this->buildMenu(0, $menu), 0, -10);
    }

    /**
     * @param $parent
     * @param $menu
     * @return string
     */
    private function buildMenu($parent, $menu): string
    {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= '<li class="dd-item" data-id="'.$menu['items'][$itemId]['id'].'">';
                    $html .= '<div class="pull-right item_actions">';
                    $html .= '<div class="btn btn-sm btn-danger pull-right delete" data-id="'.$menu['items'][$itemId]['id'].'">';
                    $html .= '<i class="voyager-trash"></i> Delete';
                    $html .= '</div>';
                    $html .= '<div class="btn btn-sm btn-primary pull-right edit"';
                    $html .= 'data-id="'.$menu['items'][$itemId]['id'].'"  data-title="'.$menu['items'][$itemId]['title'].'"';
                    $html .= 'data-url="'.$menu['items'][$itemId]['url'].'" data-route="'.$menu['items'][$itemId]['route'].'">';
                    $html .= '<i class="voyager-edit"></i> Edit';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="dd-handle">';
                    $html .= '<span>'.$menu['items'][$itemId]['title'].'</span>';
                    if (isset($menu['items'][$itemId]['route'])) {
                        $html .= '<small class="url">/'.$menu['items'][$itemId]['route'].'</small>';
                    } else {
                        $html .= '<small class="url">'.$menu['items'][$itemId]['url'].'</small>';
                    }
                    $html .= '</div>';
                    $html .= '</li>';
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= '<li class="dd-item" data-id="'.$menu['items'][$itemId]['id'].'">';
                    $html .= '<div class="pull-right item_actions">';
                    $html .= '<div class="btn btn-sm btn-danger pull-right delete" data-id="'.$menu['items'][$itemId]['id'].'">';
                    $html .= '<i class="voyager-trash"></i> Delete';
                    $html .= '</div>';
                    $html .= '<div class="btn btn-sm btn-primary pull-right edit"';
                    $html .= 'data-id="'.$menu['items'][$itemId]['id'].'"  data-title="'.$menu['items'][$itemId]['title'].'"';
                    $html .= 'data-url="'.$menu['items'][$itemId]['url'].'" data-route="'.$menu['items'][$itemId]['route'].'">';
                    $html .= '<i class="voyager-edit"></i> Edit';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="dd-handle">';
                    $html .= '<span>'.$menu['items'][$itemId]['title'].'</span>';
                    if (isset($menu['items'][$itemId]['route'])) {
                        $html .= '<small class="url">/'.$menu['items'][$itemId]['route'].'</small>';
                    } else {
                        $html .= '<small class="url">'.$menu['items'][$itemId]['url'].'</small>';
                    }
                    $html .= '</div>';
                    $html .= '<ol class="dd-list">';
                    $html .= $this->buildMenu($itemId, $menu);
                    $html .= '</li>';
                }
            }
            $html .= '</ol>';
        }
        return $html;
    }

    /**
     * Get sidebar parent and child
     *
     * @param array $menus
     * @return string
     */
    public static function getSideMenuList($menus): string
    {
        $menu = [];
        foreach ($menus as $item) {
            $menu['items'][$item['id']] = $item;
            $menu['parents'][$item['parent_id']][] = $item['id'];
        }

        return substr(self::buildSideMenu(0, $menu), 0, -10);
    }

    /**
     * @param $parent
     * @param $menu
     * @return string
     */
    private static function buildSideMenu($parent, $menu): string
    {
        $url = URL::current();
        $segments = explode('/', $url);
        $html = "";
        if (isset($menu['parents'][$parent])) {
            foreach ($menu['parents'][$parent] as $itemId) {
                $class = ($segments[4] == $menu['items'][$itemId]['route']) ? "active" : "";
                if (!isset($menu['parents'][$itemId])) {
                    if (Route::has($menu['items'][$itemId]['route']) ) {
                        $html .= '<li class="' . $class . '">';
                        $html .= '<a target="_self" href="' . route($menu['items'][$itemId]['route']) . '">';
                        $html .= '<span class="icon voyager-' . $menu['items'][$itemId]['icon'] . '"></span>&nbsp;<span class="title">' . $menu['items'][$itemId]['title'] . '</span>';
                        $html .= '</a>';
                        $html .= '</li>';
                    } else {
                        $html .= '<li class="' . $class . '">';
                        $html .= '<a target="_self" href="' . route('dashboard') . '">';
                        $html .= '<span class="icon voyager-lifebuoy"></span>&nbsp;<span class="title">' . $menu['items'][$itemId]['title'] . '</span>';
                        $html .= '</a>';
                        $html .= '</li>';
                    }
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= '<li class="dropdown '.$class.'">';
                    $html .= '<a target="_self" href="#'.$menu['items'][$itemId]['id'].'-dropdown-element" data-toggle="collapse" aria-expanded="false">';
                    $html .= '<span class="icon voyager-'.$menu['items'][$itemId]['icon'].'"></span>&nbsp;<span class="title">'.$menu['items'][$itemId]['title'].'</span>';
                    $html .= '</a>';
                    $html .= '<div id="'.$menu['items'][$itemId]['id'].'-dropdown-element" class="panel-collapse collapse">';
                    $html .= '<div class="panel-body">';
                    $html .= '<ul class="nav navbar-nav">';
                    $html .= self::buildSideMenu($itemId, $menu);
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    /**
     * Get content by type
     *
     * @param Request $request
     * @param $slug
     * @param $row
     * @param null $options
     * @return Timestamp|array|false|Expression|int|mixed|string|void|null
     */
    public function getContentBasedOnType(Request $request, $slug, $row, $options = null)
    {
        switch ($row->type) {
            case 'password':
                return (new Password($request, $slug, $row, $options))->handle();
            case 'checkbox':
                return (new Checkbox($request, $slug, $row, $options))->handle();
            case 'multiple_checkbox':
                return (new MultipleCheckbox($request, $slug, $row, $options))->handle();
            case 'file':
                return (new File($request, $slug, $row, $options))->handle();
            case 'multiple_images':
                return (new MultipleImage($request, $slug, $row, $options))->handle();
            case 'select_multiple':
                return (new SelectMultiple($request, $slug, $row, $options))->handle();
            case 'image':
                return (new ContentImage($request, $slug, $row, $options))->handle();
            case 'date':
            case 'timestamp':
                return (new Timestamp($request, $slug, $row, $options))->handle();
            case 'coordinates':
                return (new Coordinates($request, $slug, $row, $options))->handle();
            case 'relationship':
                return (new Relationship($request, $slug, $row, $options))->handle();
            default:
                return (new Text($request, $slug, $row, $options))->handle();
        }
    }

    /**
     * Upload image
     *
     * @param Request $file
     * @param $slug
     * @return bool|string
     */
    public function uploadImage($file, $slug)
    {
        // Get image base name
        $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        // Set image path
        $path = '/'. $slug .'/' .date('F') . date('Y') . '/';
        $filename_counter = 1;

        // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
        while (Storage::disk(config('storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
        }

        // Set complete image path
        $filePath = $path . $filename. '.' . $file->getClientOriginalExtension();

        // move uploaded file from temp to uploads directory
        $image = Image::make($file);
        $image->encode($file->getClientOriginalExtension(), 75);
        if (Storage::disk(config('storage.disk'))->put($filePath, (string) $image, 'public')) {
            return $filePath;
        }

        return false;
    }
}

