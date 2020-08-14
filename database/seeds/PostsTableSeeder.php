<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
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
                'title'            => 'Lorem Ipsum Post',
                'author_id'        => 0,
                'seo_title'        => null,
                'excerpt'          => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non mi nec orci euismod venenatis. Integer quis sapien et diam facilisis facilisis ultricies quis justo. Phasellus sem <b>turpis</b>, ornare quis aliquet ut, volutpat et lectus. Aliquam a egestas elit. <i>Nulla posuere</i>, sem et porttitor mollis, massa nibh sagittis nibh, id porttitor nibh turpis sed arcu.',
                'body'             => '<p>This is the body of the lorem ipsum post</p>',
                'image'            => 'posts/post1.jpg',
                'slug'             => 'lorem-ipsum-post',
                'meta_description' => 'This is the meta description',
                'meta_keywords'    => 'keyword1, keyword2, keyword3',
                'status'           => 'PUBLISHED',
                'featured'         => 0,
            ], [
                'title'     => 'The standard',
                'author_id' => 0,
                'seo_title' => null,
                'excerpt'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non mi nec orci euismod venenatis. Integer quis sapien et diam facilisis facilisis ultricies quis justo. Phasellus sem <b>turpis</b>, ornare quis aliquet ut, volutpat et lectus. Aliquam a egestas elit. <i>Nulla posuere</i>, sem et porttitor mollis, massa nibh sagittis nibh, id porttitor nibh turpis sed arcu.',
                'body'      => '<p>This is the body for the sample post, which includes the body.</p><h2>We can use all kinds of format!</h2><p>And include a bunch of other stuff.</p>',
                'image'            => 'posts/post2.jpg',
                'slug'             => 'the-standard',
                'meta_description' => 'Meta Description for sample post',
                'meta_keywords'    => 'keyword1, keyword2, keyword3',
                'status'           => 'PUBLISHED',
                'featured'         => 0,
            ], [
                'title'     => '1914 translation',
                'author_id' => 0,
                'seo_title' => null,
                'excerpt'   => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.',
                'body'      => '<p>who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?</p>',
                'image'            => 'posts/post2.jpg',
                'slug'             => '1914-translation',
                'meta_description' => 'Meta Description for sample post',
                'meta_keywords'    => 'keyword1, keyword2, keyword3',
                'status'           => 'PUBLISHED',
                'featured'         => 0,
            ]
        ];

        DB::table('posts')->insert($data);
    }
}

