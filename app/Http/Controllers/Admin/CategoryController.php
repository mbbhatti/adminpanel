<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Show all categories.
     *
     * @return View
     */
    public function list()
    {
        $categories = $this->category->getAllCategories();
        $keys = empty($categories) ? [] : array_keys($categories[0]);

        return view('Admin\Category\list', [
            'categories' => $categories,
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
            'order' => 'required|integer',
            'name' =>  'required|string|min:4|unique:categories,name,'.$id.',id',
            'slug' => 'required|string'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * UpdateOrNew category.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        $id = request('id');
        $route = 'admin/categories/create';
        if (isset($id)) {
            $route = 'admin/categories/'. $id . '/edit';
        }

        // Check post request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {
            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $this->category->saveCategory($request);
            }

            return redirect('admin/categories');
        }

        $category = [];
        if (isset($id)) {
            $category = $this->category->getCategoryById($id);
        }

        $categories = $this->category->getParentCategoriesOptions();
        return view('Admin\Category\edit-add', [
            'categories' => $categories,
            'category' => $category,
            'id' => $id,
            'route' => $route
        ]);
    }

    /**
     * Delete a category.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        if ($this->category->deleteCategory($id)) {
            return redirect('admin/categories');
        }

        return redirect('admin/categories')->withErrors(['Category does not exist.']);
    }

    /**
     * Delete all categories.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function bulkDelete(Request $request)
    {
        $redirectTo = 'admin/categories';
        $ids = $request->get('ids');
        if ($ids === null) {
            return redirect($redirectTo);
        }

        $rows = explode(',', $ids);
        if ($this->category->deleteCategories($rows)) {
            return redirect($redirectTo);
        }

        return redirect($redirectTo)->withErrors(['Categories can not be deleted.']);
    }
}

