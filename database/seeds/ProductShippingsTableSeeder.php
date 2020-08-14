<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductShippingsTableSeeder extends Seeder
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
                'weight'        => 4.50
            ]
        ];

        DB::table('product_shippings')->insert($data);
    }
}

