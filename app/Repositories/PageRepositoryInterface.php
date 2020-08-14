<?php

namespace App\Repositories;

interface PageRepositoryInterface
{
    /**
     * Get all pages list.
     *
     * @return array
     */
    public function getAllPages(): array;

    /**
     * Get page by id.
     *
     * @param int $id
     * @return object
     */
    public function getPageById(int $id): object;

    /**
     * Get page image
     *
     * @param int $id
     * @return object
     */
    public function getPageImageById(int $id): object;

    /**
     * Create | Update page.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function savePage(object $request, string $filePath): int;

    /**
     * Delete page.
     *
     * @param int $id
     * @return bool
     */
    public function deletePage(int $id): bool;

    /**
     * Delete pages.
     *
     * @param array $pages
     * @return bool
     */
    public function deletePages(array $pages): bool;

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions():  array;

    /**
     * Get template options.
     *
     * @return array
     */
    public function getTemplateOptions(): array;
}

