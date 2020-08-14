<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPricesTableSeeder extends Seeder
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
                'product_id'    => 1,
                'regular_price' => 25.69,
                'sale_price'    => 22.00,
                'from_date'     => '2020-07-07',
                'to_date'       => '2020-07-22'
            ]
        ];

        DB::table('product_prices')->insert($data);
    }
}

