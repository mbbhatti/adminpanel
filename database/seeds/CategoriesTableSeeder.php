<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
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
                'parent_id' => null,
                'order' => 1,
                'name' => 'Category 1',
                'slug' => 'category-1'
            ],
            [
                'parent_id' => null,
                'order' => 2,
                'name' => 'Category 2',
                'slug' => 'category-2'
            ],
            [
                'parent_id' => null,
                'order' => 3,
                'name' => 'Category 3',
                'slug' => 'category-3'
            ],
        ];

        DB::table('categories')->insert($data);
    }
}

