<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Employer;
use App\Models\JobSeeker;

class UploadController extends Controller
{

    ////////////////////////////////////////////
    // Employers
    ////////////////////////////////////////////
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

    ////////////////////////////////////////////
    // Job Seeker
    ////////////////////////////////////////////
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:2048', // 2MB max
        ]);

        $path = $request->file('profile_picture')->store('profile_pictures');

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $path = $request->file('resume')->store('resumes');

        return response()->json(['success' => true, 'path' => $path]);
    }
    ////////////////////////////////////////////
    // Deletion
    ////////////////////////////////////////////
    public function deleteFile(Request $request)
    {
        try {
            $path = $request->input('url');  // Changed from 'path' to 'url'
            $type = $request->input('type');
            $id = $request->input('job_seeker_id');  // Changed from 'id' to 'job_seeker_id'

            \Log::info("Deleting file. Type: {$type}, ID: {$id}, Path: {$path}");

            $fileDeleted = false;

            if ($path !== null && Storage::exists($path)) {
                Storage::delete($path);
                $fileDeleted = true;
            }

            if ($type === 'profile_picture' || $type === 'resume') {
                $jobSeeker = JobSeeker::find($id);
                if ($jobSeeker) {
                    if ($type === 'profile_picture') {
                        $jobSeeker->profile_picture_url = null;
                    } elseif ($type === 'resume') {
                        $jobSeeker->resume_url = null;
                    }
                    $jobSeeker->save();
                    \Log::info("Updated JobSeeker {$id}: Set {$type} to null");
                } else {
                    \Log::warning("JobSeeker with ID {$id} not found.");
                    return response()->json([
                        'success' => false,
                        'message' => "JobSeeker with ID {$id} not found.",
                    ], 404);
                }
            }

            return response()->json([
                'success' => true,
                'message' => $fileDeleted ? 'File deleted from storage and database.' : 'File not found in storage, but removed from database.',
            ]);
        } catch (\Exception $e) {
            \Log::error('File deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the file: ' . $e->getMessage(),
            ], 500);
        }
    }
}