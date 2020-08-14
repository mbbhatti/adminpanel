<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * @var BannerRepository
     */
    protected $banner;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * PageController constructor.
     *
     * @param BannerRepository $banner
     * @param Helper $helper
     */
    public function __construct(BannerRepository $banner, Helper $helper)
    {
        $this->banner = $banner;
        $this->helper = $helper;
    }

    /**
     * Show all products.
     *
     * @return View
     */
    public function list()
    {
        $banners = $this->banner->getAll();

        return view('Admin\Banner\show', [
            'banners' => $banners
        ]);
    }

    /**
     * Validate incoming request.
     *
     * @param  array  $data use for request data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'image' => 'required'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * UpdateOrNew product.
     *
     * @param Request $request
     * @return RedirectResponse | View
     */
    public function create(Request $request)
    {
        // Form data validation
        $validator = $this->validator($request->all());

        // Check validation
        if ($validator->fails()) {
            return redirect('admin/banners/create')->withErrors($validator)->withInput();
        } else {
            $this->banner->saveBanner($request);
        }

        return redirect()->back()->with('success', 'Banner images updated');
    }
}

