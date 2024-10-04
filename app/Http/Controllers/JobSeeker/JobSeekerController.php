<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobSeeker;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{

    public function index()
    {
        $jobSeeker = auth()->user()->jobSeeker;
        return view('dashboard.job-seekers.index', compact('jobSeeker'));
    }

    public function create()
    {
        return view('dashboard.job-seekers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:job_seekers,email',
            'phone_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|max:2048',
            'resume' => 'required|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture_url'] = asset('storage/' . $profilePicturePath);
        }

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $validated['resume_url'] = asset('storage/' . $resumePath);
        }

        $jobSeeker = JobSeeker::create([
            'user_id' => auth()->id(),
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'location' => $validated['location'],
            'bio' => $validated['bio'],
            'profile_picture_url' => $validated['profile_picture_url'] ?? null,
            'resume_url' => $validated['resume_url'],
        ]);

        return redirect()->route('job_seekers.show', $jobSeeker)->with('success', 'Profile created successfully!');
    }

    public function show(JobSeeker $jobSeeker)
    {
        return view('job_seekers.show', compact('jobSeeker'));
    }
}