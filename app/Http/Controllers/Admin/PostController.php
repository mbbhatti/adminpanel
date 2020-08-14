<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * PageController constructor.
     *
     * @param PostRepository $post
     * @param CategoryRepository $category
     * @param Helper $helper
     */
    public function __construct(PostRepository $post, CategoryRepository $category, Helper $helper)
    {
        $this->post = $post;
        $this->category = $category;
        $this->helper = $helper;
    }

    /**
     * Show all posts.
     *
     * @return View
     */
    public function list()
    {
        $posts = $this->post->getAllPost();
        $keys = empty($posts) ? [] : array_keys($posts[0]);

        return view('Admin\Post\list', [
            'posts' => $posts,
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
            'slug' =>  'required|string|unique:posts,slug,'.$id.',id',
            'title' =>  'required|string|min:4',
            'body' => 'required|string'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * UpdateOrNew post.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        $id = request('id');
        $route = 'admin/posts/create';
        if (isset($id)) {
            $route = 'admin/posts/'. $id . '/edit';
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
                    // Remove previous post image
                    if (isset($id)) {
                        $image = $this->post->getPostImageById($id);
                        if (Storage::disk(config('storage.disk'))->exists($image['image'])) {
                            Storage::disk(config('storage.disk'))->delete($image['image']);
                        }
                    }

                    // Upload new post image
                    $filePath = $this->helper->uploadImage($request->file('image'), 'posts');
                    if ($filePath == false) {
                        return redirect($route)
                            ->withErrors(['Upload Fail: Unknown error occurred!'])
                            ->withInput();
                    }
                }

                // Add or Update page
                $this->post->savePage($request, $filePath);
            }

            return redirect('admin/posts');
        }

        $post = [];
        if (isset($id)) {
            $post = $this->post->getPostById($id);
        }
        $status = $this->post->getStatusOptions();
        $categories  = $this->category->getParentCategoriesOptions();

        return view('Admin\Post\edit-add', [
            'post' => $post,
            'id' => $id,
            'route' => $route,
            'status' => $status,
            'categories' => $categories
        ]);
    }

    /**
     * Delete a post.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        if ($this->post->deletePost($id)) {
            return redirect('admin/posts');
        }

        return redirect('admin/posts')->withErrors(['post does not exist.']);
    }

    /**
     * Delete all posts.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function bulkDelete(Request $request)
    {
        $redirectTo = 'admin/posts';
        $ids = $request->get('ids');
        if ($ids === null) {
            return redirect($redirectTo);
        }

        $rows = explode(',', $ids);
        if ($this->post->deletePosts($rows)) {
            return redirect($redirectTo);
        }

        return redirect($redirectTo)->withErrors(['Posts can not be deleted.']);
    }
}

