<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
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
                'name'            => 'Juice',
                'description'     => '<p>We are glad to welcome customers from all over the world and offer the best food and ingredients for your joy! We know that it is almost impossible to satisfy all cuisine whims of our visitors but we are working on it &ndash; so if you can\'t find what you were looking for, please feel free to contact our awesome Support to leave your request and we\'ll get back to you as soon as possible.</p>
<h3>Flawless quality and low prices &ndash; these are the main cornerstones that have helped us build our business</h3>
<div class="rte_youtube_wrapper"><iframe src="https://www.youtube-nocookie.com/embed/ctAEWKgCSZA?rel=0" width="1280" height="720" allowfullscreen="allowfullscreen" data-mce-fragment="1"></iframe></div>
<p>There is nothing more important than our client\'s needs and perfect reputation of our shop. Sharing is everything and we are glad to share our latest creative ideas about banquet menus and decoration, original recipes etc.</p>
<h4>What do you expect from your purchase?</h4>
<p>We are glad to welcome customers from all over the world and offer the best food and ingredients for your joy! Building huge and interesting community is very important for us because strong and long-term business and social relationships are great way earn benefits together. You can easily join our community on Facebook or follow us on Twitter &ndash; so stay tuned!</p>',
                'excerpt'      => 'We are glad to welcome customers from all over the world and offer the best food and ingredients for your joy! We know that it is almost impossible to satisfy all cuisine whims of our visitors but we are working on it – so if you can\'t find what you were looking for, please feel free to contact our awesome Support to leave your request and we\'ll get back to you as soon as possible.',
                'category_id'  => 2,
                'image'        => '/products/July2020/lake.jpg',
                'gallery'       => '/storage/products/July2020/juise_1_470x509_crop_top1.png',
                'status'        => 'PUBLISHED',
                'featured'      => 1,
            ]
        ];

        DB::table('products')->insert($data);
    }
}

