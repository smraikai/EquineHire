<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Employer;

class UploadController extends Controller
{
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:3072', // 3MB max
        ]);

        $path = $request->file('logo')->store('employer_logos');

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function uploadFeaturedImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|max:5120', // 5MB max
        ]);

        $path = $request->file('featured_image')->store('employer_featured_images');

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:5120', // 5MB max, PDF only
        ]);

        $path = $request->file('resume')->store('resumes');

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::url($path)
        ]);
    }

    public function deleteFile(Request $request)
    {
        $path = $request->input('path');
        $type = $request->input('type');
        $employerId = $request->input('employer_id');

        $employer = Employer::findOrFail($employerId);
        $fileDeleted = false;

        if (Storage::exists($path)) {
            Storage::delete($path);
            $fileDeleted = true;
        }

        if ($type === 'logo') {
            $employer->logo = null;
        } elseif ($type === 'featured_image') {
            $employer->featured_image = null;
        }
        $employer->save();

        return response()->json([
            'success' => true,
            'message' => $fileDeleted ? 'File deleted from storage and database.' : 'File not found in storage, but removed from database.',
        ]);
    }
}