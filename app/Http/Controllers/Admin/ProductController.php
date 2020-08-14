<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\ProductPriceRepository;
use App\Repositories\ProductInventoryRepository;
use App\Repositories\ProductShippingRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $product;

    /**
     * @var ProductPriceRepository
     */
    protected $productPrice;

    /**
     * @var ProductInventoryRepository
     */
    protected $productInventory;

    /**
     * @var ProductShippingRepository
     */
    protected $productShipping;

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
     * @param ProductRepository $product
     * @param ProductPriceRepository $productPrice
     * @param ProductInventoryRepository $productInventory
     * @param ProductShippingRepository $productShipping
     * @param CategoryRepository $category
     * @param Helper $helper
     */
    public function __construct(
        ProductRepository $product,
        ProductPriceRepository $productPrice,
        ProductInventoryRepository $productInventory,
        ProductShippingRepository $productShipping,
        CategoryRepository $category,
        Helper $helper
    )
    {
        $this->product = $product;
        $this->productPrice = $productPrice;
        $this->productInventory = $productInventory;
        $this->productShipping = $productShipping;
        $this->category = $category;
        $this->helper = $helper;
    }

    /**
     * Show all products.
     *
     * @return View
     */
    public function list()
    {
        $products = $this->product->getAllProducts();
        $keys = empty($products) ? [] : array_keys($products[0]);

        return view('Admin\Product\list', [
            'products' => $products,
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
            'name' =>  'required|string|unique:products,name,'.$id.',id',
            'description' => 'required|string'
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
        $id = request('id');
        $route = 'admin/products/create';
        if (isset($id)) {
            $route = 'admin/products/'. $id . '/edit';
        }

        // Check product request
        if ($request->method() == 'PUT' || $request->method() == 'POST') {

            // Form data validation
            $validator = $this->validator($request->all(), $id);

            // Check validation
            if ($validator->fails()) {
                return redirect($route)->withErrors($validator)->withInput();
            } else {
                $filePath = '';
                if ($request->has('image')) {
                    // Remove previous product image
                    if (isset($id)) {
                        $image = $this->product->getProductImageById($id);
                        if (Storage::disk(config('storage.disk'))->exists($image['image'])) {
                            Storage::disk(config('storage.disk'))->delete($image['image']);
                        }
                    }

                    // Upload new product image
                    $filePath = $this->helper->uploadImage($request->file('image'), 'products');
                    if ($filePath == false) {
                        return redirect($route)
                            ->withErrors(['Upload Fail: Unknown error occurred!'])
                            ->withInput();
                    }
                }

                // Add or Update product
                $this->product->saveProduct($request, $filePath);

                // Add or Update product price
                $this->productPrice->saveProductPrice($request);

                // Add or Update product Inventory
                $this->productInventory->saveProductInventory($request);

                // Add or Update product Shipping
                $this->productShipping->saveProductShipping($request);
            }

            return redirect('admin/products');
        }

        $product = [];
        if (isset($id)) {
            $product = $this->product->getProductById($id);
            $galleries = $product['gallery'] ?? '';
            if ($product['gallery'] !== null) {
                $product['galleries'] = explode(',',$galleries);
            }
        }
        $status = $this->product->getStatusOptions();
        $stockStatus = $this->productInventory->getStatusOptions();
        $categories  = $this->category->getParentCategoriesOptions();

        return view('Admin\Product\edit-add', [
            'product' => $product,
            'id' => $id,
            'route' => $route,
            'status' => $status,
            'categories' => $categories,
            'stocks' => $stockStatus
        ]);
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        if ($this->product->deleteProduct($id)) {
            return redirect('admin/products');
        }

        return redirect('admin/products')->withErrors(['Product does not exist.']);
    }

    /**
     * Delete all products.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function bulkDelete(Request $request)
    {
        $redirectTo = 'admin/products';
        $ids = $request->get('ids');
        if ($ids === null) {
            return redirect($redirectTo);
        }

        $rows = explode(',', $ids);
        if ($this->product->deleteProducts($rows)) {
            return redirect($redirectTo);
        }

        return redirect($redirectTo)->withErrors(['Products can not be deleted.']);
    }
}

