<?php

namespace App\Repositories;

use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return array
     */
    public function getAllProducts(): array
    {
        return Product::select(
            'products.id',
            'products.image',
            'products.name',
            'product_inventories.sku',
            'product_inventories.stock_status AS Stock',
            'product_prices.regular_price AS Price',
            'product_prices.sale_price AS Sale Price',
            'products.featured',
            'products.status',
            'products.created_at AS Publish Date',
            'categories.name AS Category'
        )
            ->leftJoin('product_inventories', 'products.id', '=', 'product_inventories.product_id')
            ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->orderBy('products.id', 'ASC')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get product by id.
     *
     * @param $id
     * @return object
     */
    public function getProductById($id): object
    {
        return Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.excerpt',
            'products.category_id',
            'products.image',
            'products.status',
            'products.featured',
            'products.gallery',
            'product_inventories.sku',
            'product_inventories.stock_status',
            'product_prices.regular_price',
            'product_prices.sale_price',
            'product_prices.from_date',
            'product_prices.to_date',
            'product_shippings.weight',
            'product_shippings.width',
            'product_shippings.length',
            'product_shippings.height'

        )
            ->leftJoin('product_inventories', 'products.id', '=', 'product_inventories.product_id')
            ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->leftJoin('product_shippings', 'products.id', '=', 'product_shippings.product_id')
            ->where('products.id', $id)
            ->first();
    }

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions(): array
    {
        return [
            'PUBLISHED' => 'Published',
            'DRAFT' => 'Draft',
            'PENDING' => 'Pending'
        ];
    }

    /**
     * Get product image
     *
     * @param int $id
     * @return object
     */
    public function getProductImageById(int $id): object
    {
        return Product::select('image')->where('id', $id)->first();
    }

    /**
     * Create | Update product.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function saveProduct(object $request, string $filePath): int
    {
        $product = Product::firstOrNew(['id' => request('id')]);
        $product->category_id = $request->input('category_id') ?? null;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->excerpt = $request->input('excerpt');
        if (!empty($filePath)) {
            $product->image = $filePath;
        }
        $product->status = $request->input('status');
        $product->featured = $request->input('featured') ?? 0;
        $product->gallery = $request->input('gallery');
        $product->save();

        return $product->id;
    }

    /**
     * Delete product.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        return Product::where('id', $id)->delete();
    }

    /**
     * Delete products.
     *
     * @param array $posts
     * @return bool
     */
    public function deleteProducts(array $posts): bool
    {
        return Product::whereIn('id', $posts)->delete();
    }
}

