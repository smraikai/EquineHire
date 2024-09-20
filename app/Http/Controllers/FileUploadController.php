<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('logos', 's3');
            $url = Storage::disk('s3')->url($path);
            $webpUrl = $this->convertToWebpUrl($url);
            return response()->json(['path' => $webpUrl]);
        } elseif ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $path = $file->store('featured_images', 's3');
            $url = Storage::disk('s3')->url($path);
            $webpUrl = $this->convertToWebpUrl($url);
            return response()->json(['path' => $webpUrl]);
        }
        if ($request->hasFile('additional_photos')) {
            $files = $request->file('additional_photos');
            $paths = [];
            foreach ($files as $file) {
                $path = $file->store('additional_photos', 's3');
                $url = Storage::disk('s3')->url($path);
                $webpUrl = $this->convertToWebpUrl($url);
                $paths[] = $webpUrl;
            }
            return response()->json(['paths' => $paths]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    protected function convertToWebpUrl($url)
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];
        $newPath = preg_replace('/\.[^.]+$/', '.webp', $path);
        return $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $newPath;
    }

    public function load(Request $request)
    {
        $url = $request->query('load');
        $contents = file_get_contents($url);
        return response($contents)->header('Content-Type', 'image/webp');
    }

}
