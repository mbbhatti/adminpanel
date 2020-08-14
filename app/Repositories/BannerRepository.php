<?php

namespace App\Repositories;

use App\Banner;
use Illuminate\Support\Facades\Auth;

class BannerRepository implements BannerRepositoryInterface
{
    /**
     * Get all banners
     *
     * @return object
     */
    public function getAll(): ?object
    {
        return Banner::select('id', 'caption', 'description', 'image')->get();
    }

    /**
     * Create | Update banner.
     *
     * @param object $request
     * @return bool
     */
    public function saveBanner(object $request): bool
    {
        // Delete all previous records
        $this->deleteAll();

        // Insert new records
        $caption = $request->input('caption');
        $images = $request->input('image');
        foreach ($images  as $key => $image) {
            $banners = Banner::firstOrNew(['image' => $image]);
            $banners->author_id = Auth::user()->getKey('id');
            $banners->caption = $caption[$key] ?? null;
            $banners->image = $image;
            $banners->save();
        }

        return true;
    }

    /**
     * Delete all record
     *
     * @return mixed
     */
    public function deleteAll()
    {
        return Banner::truncate();
    }
}

