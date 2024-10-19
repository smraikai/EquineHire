<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobSeekerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jobSeeker = $user->jobSeeker;
        $applications = JobApplication::where('job_seeker_id', $jobSeeker->id)->with('jobListing')->get();

        return view('dashboard.job-seeker.index', [
            'user' => $user,
            'jobSeeker' => $jobSeeker,
            'applications' => $applications,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.job-seeker.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $jobSeeker = $user->jobSeeker;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'resume_path' => 'nullable|string',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $jobSeeker->update([
            'phone' => $validated['phone'],
        ]);

        // Handle resume path update
        if ($request->has('resume_path')) {
            // Delete old resume if exists
            if ($jobSeeker->resume_path) {
                Storage::delete($jobSeeker->resume_path);
            }

            $jobSeeker->resume_path = $validated['resume_path'];
            $jobSeeker->save();
        }

        return redirect()->route('dashboard.job-seeker.index')->with('success', 'Profile updated successfully.');
    }
}