<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\User;
use App\Models\JobSeeker;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewJobApplicationMail;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create']);
    }

    public function create(JobListing $jobListing)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('message', 'Please create an account or log in to apply for this job.')
                ->with('redirect_after_login', route('job-applications.create', $jobListing));
        }
        return view('job-applications.create', compact('jobListing'));
    }

    public function store(Request $request, JobListing $jobListing)
    {
        Log::info('Job application submission started', ['job_listing_id' => $jobListing->id]);

        try {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'cover_letter' => 'required|string|max:5000',
                'resume_path' => 'required|string',
            ];

            $validated = $request->validate($rules);

            Log::info('Validation passed', ['job_listing_id' => $jobListing->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', [
                'job_listing_id' => $jobListing->id,
                'errors' => $e->errors(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            // Update or create JobSeeker profile
            $jobSeeker = JobSeeker::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'resume_path' => $validated['resume_path'] ?? null,
                ]
            );

            $jobApplication = JobApplication::create([
                'job_listing_id' => $jobListing->id,
                'job_seeker_id' => $jobSeeker->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'cover_letter' => $validated['cover_letter'],
                'resume_path' => $validated['resume_path'],
            ]);

            // Use the email_link from the JobListing
            $jobListingEmail = $jobListing->email_link;

            // Send email to employer
            if ($jobListingEmail) {
                Mail::to($jobListingEmail)->send(new NewJobApplicationMail($jobApplication));
                Log::info('Job application email sent to employer', ['employer_email' => $jobListingEmail]);
            } else {
                Log::warning('No employer email found for job listing', ['job_listing_id' => $jobListing->id]);
            }

        } catch (\Exception $e) {
            Log::error('Failed to create job application or send email', ['error' => $e->getMessage()]);
            return back()->withErrors(['application_creation' => 'Failed to submit job application. Please try again.'])->withInput();
        }

        Log::info('Job application submission completed', ['job_application_id' => $jobApplication->id]);

        $successMessage = 'Your application has been submitted successfully!';

        return redirect()->route('jobs.show', [
            'job_slug' => $jobListing->slug,
            'id' => $jobListing->id
        ])->with('success', $successMessage);
    }
}