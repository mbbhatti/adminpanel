<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * @var PageRepository
     */
    protected $page;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * PageController constructor.
     *
     * @param PageRepository $page
     * @param Helper $helper
     */
    public function __construct(PageRepository $page, Helper $helper)
    {
        $this->page = $page;
        $this->helper = $helper;
    }

    /**
     * Show all pages.
     *
     * @return View
     */
    public function list()
    {
        $pages = $this->page->getAllPages();
        $keys = empty($pages) ? [] : array_keys($pages[0]);

        return view('Admin\Page\list', [
            'pages' => $pages,
            'keys' => $keys
        ]);
    }

    /**
     * Validate incoming request.
     *
     * @param  array  $data use for request data
     * @param  int  $id     use for entity id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id)
    {
        $rules = [
            'title' =>  'required|string|min:4',
            'slug' =>  'required|string|unique:pages,slug,'.$id.',id',
            'excerpt' => 'required|string',
            'content' => 'required|string',
        ];

        return Validator::make($data, $rules);
    }

    /**
     * UpdateOrNew page.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        $id = request('id');
        $route = 'admin/pages/create';
        if (isset($id)) {
            $route = 'admin/pages/'. $id . '/edit';
        }

        // Check post request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {
            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $filePath = '';
                if ($request->has('image')) {
                    // Remove previous page image
                    if (isset($id)) {
                        $image = $this->page->getPageImageById($id);
                        if (Storage::disk(config('storage.disk'))->exists($image['image'])) {
                            Storage::disk(config('storage.disk'))->delete($image['image']);
                        }
                    }

                    // Upload new page image
                    $filePath = $this->helper->uploadImage($request->file('image'), 'pages');
                    if ($filePath == false) {
                        return redirect($route)
                            ->withErrors(['Upload Fail: Unknown error occurred!'])
                            ->withInput();
                    }
                }

                // Add or Update page
                $this->page->savePage($request, $filePath);
            }

            return redirect('admin/pages');
        }

        $page = [];
        if (isset($id)) {
            $page = $this->page->getPageById($id);
        }
        $templates = $this->page->getTemplateOptions();
        $status = $this->page->getStatusOptions();

        return view('Admin\Page\edit-add', [
            'page' => $page,
            'id' => $id,
            'route' => $route,
            'templates' => $templates,
            'status' => $status
        ]);
    }

    /**
     * Delete a page.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        if ($this->page->deletePage($id)) {
            return redirect('admin/pages');
        }

        return redirect('admin/pages')->withErrors(['Page does not exist.']);
    }

    /**
     * Delete all pages.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function bulkDelete(Request $request)
    {
        $redirectTo = 'admin/pages';
        $ids = $request->get('ids');
        if ($ids === null) {
            return redirect($redirectTo);
        }

        $rows = explode(',', $ids);
        if ($this->page->deletePages($rows)) {
            return redirect($redirectTo);
        }

        return redirect($redirectTo)->withErrors(['Pages can not be deleted.']);
    }
}

