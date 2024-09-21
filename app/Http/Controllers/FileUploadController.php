<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('photos')) {
            $file = $request->file('photos');
            $path = $file->store('temp/job-listings', 'public');
            return response($path, 200);
        }
        return response('No file uploaded.', 400);
    }

    public function load(Request $request)
    {
        $url = $request->query('load');
        $contents = file_get_contents($url);
        return response($contents)->header('Content-Type', 'image/webp');
    }

}
