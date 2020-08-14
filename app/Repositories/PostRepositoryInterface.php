<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    /**
     * Get all posts.
     *
     * @return array
     */
    public function getAllPost(): array;

    /**
     * Get post by id.
     *
     * @param int $id
     * @return object
     */
    public function getPostById(int $id): object;

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions():  array;

    /**
     * Get post image
     *
     * @param int $id
     * @return object
     */
    public function getPostImageById(int $id): object;

    /**
     * Create | Update post.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function savePage(object $request, string $filePath): int;

    /**
     * Delete post.
     *
     * @param int $id
     * @return bool
     */
    public function deletePost(int $id): bool;

    /**
     * Delete posts.
     *
     * @param array $posts
     * @return mixed
     */
    public function deletePosts(array $posts): bool;
}

