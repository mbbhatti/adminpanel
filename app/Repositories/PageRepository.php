<?php

namespace App\Repositories;

use App\Page;
use Illuminate\Support\Facades\Auth;

class PageRepository implements PageRepositoryInterface
{
    /**
     * Get all pages list.
     *
     * @return array
     */
    public function getAllPages(): array
    {
        return Page::select('id', 'title', 'slug', 'status', 'image')
            ->orderBy('id', 'ASC')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get page by id.
     *
     * @param int $id
     * @return object
     */
    public function getPageById(int $id): object
    {
        return Page::select(
            'id',
            'template',
            'title',
            'excerpt',
            'content',
            'image',
            'slug',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'status'
        )
            ->where('id', $id)
            ->first();
    }

    /**
     * Get page image
     *
     * @param int $id
     * @return object
     */
    public function getPageImageById(int $id): object
    {
        return Page::select('image')->where('id', $id)->first();
    }

    /**
     * Create | Update page.
     *
     * @param  object  $request
     * @param  string  $filePath
     * @return int     last record id
     */
    public function savePage(object $request, string $filePath): int
    {
        $page = Page::firstOrNew(['id' => request('id')]);
        $page->author_id = Auth::user()->id;
        $page->template = $request->input('template');
        $page->title = $request->input('title');
        $page->excerpt = $request->input('excerpt');
        $page->content = $request->input('content');
        $page->slug = $request->input('slug');
        $page->meta_title = $request->input('meta_title');
        $page->meta_description = $request->input('meta_description');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->status = $request->input('status');
        if (!empty($filePath)) {
            $page->image = $filePath;
        }
        $page->save();

        return $page->id;
    }

    /**
     * Delete page.
     *
     * @param int $id
     * @return bool
     */
    public function deletePage(int $id): bool
    {
        return Page::where('id', $id)->delete();
    }

    /**
     * Delete pages.
     *
     * @param array $pages
     * @return bool
     */
    public function deletePages(array $pages): bool
    {
        return Page::whereIn('id', $pages)->delete();
    }

    /**
     * Get status options.
     *
     * @return array
     */
    public function getStatusOptions():  array
    {
        return [
            'INACTIVE' => 'INACTIVE',
            'ACTIVE' => 'ACTIVE'
        ];
    }

    /**
     * Get template options.
     *
     * @return array
     */
    public function getTemplateOptions(): array
    {
        return [
            'general' => 'General',
            'about_us' => 'About Us',
            'contact_us' => 'Contact Us'
        ];
    }
}

