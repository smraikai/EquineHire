<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function show(JobApplication $jobApplication)
    {
        // Ensure the employer can only view their own applications
        if ($jobApplication->jobListing->employer_id !== auth()->user()->employer->id) {
            abort(403);
        }

        return view('dashboard.applications.show', compact('jobApplication'));
    }

    public function updateStatus(Request $request, JobApplication $jobApplication)
    {
        // Ensure the employer can only update their own applications
        if ($jobApplication->jobListing->employer_id !== auth()->user()->employer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,reviewed,contacted,rejected'],
        ]);

        $jobApplication->update(['status' => $validated['status']]);

        return back()->with('success', 'Application status updated successfully.');
    }

    public function index()
    {
        $employer = auth()->user()->employer;
        $applications = JobApplication::whereIn('job_listing_id', $employer->jobListings->pluck('id'))
            ->with(['jobListing'])
            ->latest()
            ->paginate(15);

        return view('dashboard.applications.index', compact('applications'));
    }
}