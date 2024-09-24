<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:3072', // 3MB max
        ]);

        $path = $request->file('logo')->store('employer_logos', 'public');

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function uploadFeaturedImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|max:5120', // 5MB max
        ]);

        $path = $request->file('featured_image')->store('employer_featured_images', 'public');

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function deleteFile(Request $request)
    {
        $path = $request->input('path');
        $type = $request->input('type');

        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}