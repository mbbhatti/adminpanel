<?php

namespace App\Repositories;

use App\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get all posts.
     *
     * @return array
     */
    public function getAllPost(): array
    {
        return Post::select(
            'id',
            'title',
            'image',
            'status',
            'seo_title AS Seo Title',
            'featured'
        )
            ->orderBy('id', 'ASC')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get post by id.
     *
     * @param int $id
     * @return object
     */
    public function getPostById(int $id): object
    {
        return Post::where('id', $id) ->first();
    }

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions():  array
    {
        return [
            'PUBLISHED' => 'Published',
            'DRAFT' => 'Draft',
            'PENDING' => 'Pending'
        ];
    }

    /**
     * Get post image
     *
     * @param int $id
     * @return object
     */
    public function getPostImageById(int $id): object
    {
        return Post::select('image')->where('id', $id)->first();
    }

    /**
     * Create | Update post.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function savePage(object $request, string $filePath): int
    {
        $post = Post::firstOrNew(['id' => request('id')]);
        $post->author_id = Auth::user()->id;
        $post->category_id = $request->input('category_id') ?? null;
        $post->title = $request->input('title');
        $post->seo_title = $request->input('seo_title') ?? null;
        $post->excerpt = $request->input('excerpt');
        $post->body = $request->input('body');
        if (!empty($filePath)) {
            $post->image = $filePath;
        }
        $post->slug = $request->input('slug');
        $post->meta_description = $request->input('meta_description') ?? null;
        $post->meta_keywords = $request->input('meta_keywords') ?? null;
        $post->status = $request->input('status');
        $post->featured = $request->input('featured') ?? 0;
        $post->save();

        return $post->id;
    }

    /**
     * Delete post.
     *
     * @param int $id
     * @return bool
     */
    public function deletePost(int $id): bool
    {
        return Post::where('id', $id)->delete();
    }

    /**
     * Delete posts.
     *
     * @param array $posts
     * @return mixed
     */
    public function deletePosts(array $posts): bool
    {
        return Post::whereIn('id', $posts)->delete();
    }
}

