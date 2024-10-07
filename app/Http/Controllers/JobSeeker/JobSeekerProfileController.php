<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobSeeker;
use Illuminate\Http\Request;
use App\Traits\HasStates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JobSeekerProfileController extends Controller
{

    use HasStates;

    public function index()
    {
        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;

        if (!$jobSeeker) {
            // If the user doesn't have a job seeker profile, redirect to create
            return redirect()->route('job-seekers.create')->with('info', 'Please create your job seeker profile.');
        }

        return view('dashboard.job-seekers.index', compact('jobSeeker'));
    }

    public function create()
    {
        $states = $this->getStates();
        $jobSeeker = new JobSeeker();
        return view('dashboard.job-seekers.create', compact('states', 'jobSeeker'));
    }

    public function edit(JobSeeker $jobSeeker)
    {
        $states = $this->getStates();
        return view('dashboard.job-seekers.edit', compact('jobSeeker', 'states'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', JobSeeker::class);

        Log::info('Incoming request data:', $request->all());

        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
            'bio' => 'nullable|string',
            'profile_picture_url' => 'nullable|string',
            'resume_url' => 'nullable|string',
        ]);

        Log::info('Validated data:', $validatedData);

        DB::beginTransaction();

        try {
            $jobSeeker = new JobSeeker();
            $jobSeeker->user_id = auth()->id();

            if ($request->filled('profile_picture_url')) {
                $jobSeeker->profile_picture_url = $validatedData['profile_picture_url'];
                Log::info('Setting profile_picture_url:', ['url' => $jobSeeker->profile_picture_url]);
            }

            if ($request->filled('resume_url')) {
                $jobSeeker->resume_url = $validatedData['resume_url'];
                Log::info('Setting resume_url:', ['url' => $jobSeeker->resume_url]);
            }

            $jobSeeker->fill($validatedData);
            $jobSeeker->save();

            DB::commit();
            Log::info('Job seeker created:', $jobSeeker->toArray());
            return redirect()->route('dashboard.job-seekers.index')
                ->with('success', 'New job seeker profile created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating job seeker profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the job seeker profile.');
        }
    }

    public function update(Request $request, JobSeeker $jobSeeker)
    {
        $this->authorize('update', $jobSeeker);

        Log::info('Incoming request data:', $request->all());

        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
            'bio' => 'nullable|string',
            'profile_picture_url' => 'nullable|string',
            'resume_url' => 'nullable|string',
        ]);

        Log::info('Validated data:', $validatedData);

        DB::beginTransaction();

        try {
            if ($request->filled('profile_picture_url')) {
                // Delete old profile picture if exists
                if ($jobSeeker->profile_picture_url) {
                    Storage::delete($jobSeeker->profile_picture_url);
                }
                $jobSeeker->profile_picture_url = $validatedData['profile_picture_url'];
                Log::info('Setting profile_picture_url:', ['url' => $jobSeeker->profile_picture_url]);
            }

            if ($request->filled('resume_url')) {
                // Delete old resume if exists
                if ($jobSeeker->resume_url) {
                    Storage::delete($jobSeeker->resume_url);
                }
                $jobSeeker->resume_url = $validatedData['resume_url'];
                Log::info('Setting resume_url:', ['url' => $jobSeeker->resume_url]);
            }

            $jobSeeker->update($validatedData);

            DB::commit();
            Log::info('Job seeker updated:', $jobSeeker->toArray());
            return redirect()->route('dashboard.job-seekers.index', $jobSeeker)
                ->with('success', 'Job seeker profile updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating job seeker profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the job seeker profile.');
        }
    }

    public function show(JobSeeker $jobSeeker)
    {
        return view('dashboard.job-seekers.index', compact('jobSeeker'));
    }

    public function destroy(JobSeeker $jobSeeker)
    {
        $this->authorize('delete', $jobSeeker);

        DB::beginTransaction();

        try {
            // Delete profile picture if exists
            if ($jobSeeker->profile_picture_url) {
                Storage::delete($jobSeeker->profile_picture_url);
            }

            // Delete resume if exists
            if ($jobSeeker->resume_url) {
                Storage::delete($jobSeeker->resume_url);
            }

            // Delete the job seeker profile
            $jobSeeker->delete();

            DB::commit();
            Log::info('Job seeker profile deleted:', ['id' => $jobSeeker->id]);
            return redirect()->route('dashboard')
                ->with('success', 'Your job seeker profile has been deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting job seeker profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the job seeker profile.');
        }
    }
}