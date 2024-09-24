<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('logos', 's3');
            $url = Storage::disk('s3')->url($path);

            return response()->json([
                'url' => $url,
                'path' => $path
            ], 200, [], JSON_UNESCAPED_SLASHES);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function delete(Request $request)
    {
        $path = $request->input('path');
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}