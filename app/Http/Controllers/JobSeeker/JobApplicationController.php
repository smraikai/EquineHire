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
    public function create(JobListing $jobListing)
    {
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
                'resume_path' => 'nullable|string',
                'create_account' => 'boolean',
            ];

            if ($request->boolean('create_account')) {
                $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
            }

            $validated = $request->validate($rules);
            $validated['create_account'] = $request->boolean('create_account');

            Log::info('Validation passed', ['job_listing_id' => $jobListing->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', [
                'job_listing_id' => $jobListing->id,
                'errors' => $e->errors(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        // Handle user account and JobSeeker profile
        if ($validated['create_account']) {
            try {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'is_employer' => false,
                ]);

                event(new Registered($user));
                Auth::login($user);
                Log::info('User account created', ['user_id' => $user->id]);

                // Create JobSeeker profile for new user
                $jobSeeker = JobSeeker::create([
                    'user_id' => $user->id,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'resume_path' => $validated['resume_path'] ?? null,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000) { // Integrity constraint violation
                    Log::info('Attempt to create duplicate account', ['email' => $validated['email']]);
                    return back()->withErrors([
                        'email' => 'An account with this email already exists. Please log in to continue.',
                    ])->withInput();
                }
                Log::error('Failed to create user account', ['error' => $e->getMessage()]);
                return back()->withErrors(['account_creation' => 'Failed to create user account. Please try again.'])->withInput();
            }
        } else {
            $user = Auth::user();
            if ($user) {
                try {
                    // Update existing JobSeeker profile
                    $jobSeeker = JobSeeker::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                            'phone' => $validated['phone'] ?? null,
                            'resume_path' => $validated['resume_path'] ?? null,
                        ]
                    );
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == 23000) { // Integrity constraint violation
                        Log::warning('Attempt to update to existing email', ['email' => $validated['email']]);
                        return back()->withErrors([
                            'email' => 'This email is already associated with another job seeker profile.',
                        ])->withInput();
                    }
                    throw $e;
                }
            } else {
                // No account, no JobSeeker profile
                $jobSeeker = null;
            }
        }

        try {
            $jobApplication = JobApplication::create([
                'job_listing_id' => $jobListing->id,
                'job_seeker_id' => $jobSeeker ? $jobSeeker->id : null,
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