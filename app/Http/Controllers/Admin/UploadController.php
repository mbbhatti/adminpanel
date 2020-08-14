<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    /**
     * Upload media files.
     *
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        // Get image file
        $file = $request->file('image');
        // Get image store for
        $slug = $request->input('type_slug');
        // Get image base name
        $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        // Set image path
        $path = '/' . $slug . '/' . date('F') . date('Y') . '/';
        $filename_counter = 1;

        // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
        while (Storage::disk(config('storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
        }

        // Set complete image path
        $filePath = $path . $filename. '.' . $file->getClientOriginalExtension();

        // move uploaded file from temp to uploads directory
        $image = Image::make($file);
        $image->encode($file->getClientOriginalExtension(), 75);
        if (Storage::disk(config('storage.disk'))->put($filePath, (string) $image, 'public')) {
            $host = $request->getSchemeAndHttpHost();
            return "<script> parent.helpers.setImageValue('".$host.'/storage'.$filePath."'); </script>";
        }
    }

    // Old function used for upload media inot the public folder
    /*public function upload(Request $request)
    {
        // Get image file
        $file = $request->file('image');
        // Get image base name
        $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        // Set image path
        $path = '/pages/'.date('F').date('Y').'/';
        $publicPath = public_path($path);
        $filename_counter = 1;

        // Check image already exist
        while (file_exists($path . $filename.'.'.$file->getClientOriginalExtension())) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
        }

        // Set complete image path
        $filePath = $path . $filename. '.' . $file->getClientOriginalExtension();

        // move uploaded file from temp to uploads directory
        if ($file->move($publicPath, $filePath)) {
            $host = $request->getSchemeAndHttpHost();
            return "<script> parent.helpers.setImageValue('".$host.$filePath."'); </script>";
        }
    }*/
}

