<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductInventoriesTableSeeder extends Seeder
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
                'product_id'   => 1,
                'sku'          => '327038',
                'stock_status' => 'Out of stock'
            ]
        ];

        DB::table('product_inventories')->insert($data);
    }
}

