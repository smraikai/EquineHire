<?php

namespace App\Http\Controllers\JobListing;
use App\Http\Controllers\Controller;

use App\Models\JobListing;
use App\Models\Employer;
use App\Models\JobListingCategory;
use App\Traits\HasStates;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployerJobListingController extends Controller
{

    use HasStates;

    public function index()
    {
        $user = auth()->user();

        if (!Employer::employerProfileCheck($user)) {
            return redirect()->route('employers.index')->with('error', 'You need to complete your employer profile first.');
        }

        $jobListings = $user->jobListings()->paginate(10);
        return view('dashboard.job-listings.index', compact('jobListings'));
    }

    public function create()
    {
        $user = auth()->user();
        $employer = $user->employer;

        if (!Employer::employerProfileCheck($user)) {
            return redirect()->route('employers.index')->with('error', 'You need to complete your employer profile first.');
        }

        if (!$user->canCreateJobListing()) {
            return redirect()->route('employers.job-listings.index')->with('error', 'You have reached the job listing limit for your current subscription plan.');
        }

        $categories = JobListingCategory::all();
        $states = $this->getStates();
        return view('dashboard.job-listings.create', compact('categories', 'states'));
    }

    public function edit(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);
        $categories = JobListingCategory::all();
        $states = $this->getStates();
        return view('dashboard.job-listings.edit', compact('jobListing', 'categories', 'states'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateJobListing($request);
        $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title']);

        $user = auth()->user();
        $employer = $user->employer;

        $validatedData['employer_id'] = $employer->id;
        $validatedData['user_id'] = $user->id;

        try {
            JobListing::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the job listing. Please try again.');
        }

        return redirect()->route('employers.job-listings.index')->with('success', 'Job listing created successfully.');
    }

    public function update(Request $request, JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);

        $validatedData = $this->validateJobListing($request);

        $jobListing->update($validatedData);

        return redirect()->route('employers.job-listings.index')->with('success', 'Job listing updated successfully.');
    }

    public function destroy(JobListing $jobListing)
    {
        $this->authorize('delete', $jobListing);

        $jobListing->delete();

        return redirect()->route('employers.job-listings.index')
            ->with('success', 'Job listing deleted successfully.');
    }

    private function validateJobListing(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:job_listing_categories,id',
            'description' => 'required',
            'remote_position' => 'required|boolean',
            'city' => 'nullable|required_if:remote_position,0|string|max:255',
            'state' => 'nullable|required_if:remote_position,0|string|in:' . implode(',', $this->getStates()),
            'job_type' => 'required|in:full-time,part-time,contract,temp,freelance,internship,externship,seasonal,working-student',
            'experience_required' => 'required|in:0-1 Years,1-2 Years,2-5 Years,5+ Years',
            'salary_type' => 'nullable|in:hourly,salary',
            'hourly_rate_min' => 'required_if:salary_type,hourly|nullable|numeric|min:10|max:100',
            'hourly_rate_max' => 'required_if:salary_type,hourly|nullable|numeric|min:15|max:200|gt:hourly_rate_min',
            'salary_range_min' => 'required_if:salary_type,salary|nullable|numeric|min:10000|max:100000',
            'salary_range_max' => 'required_if:salary_type,salary|nullable|numeric|min:20000|max:300000|gt:salary_range_min',
            'application_type' => 'required|in:link,email',
            'application_link' => 'required_if:application_type,link|nullable|url',
            'email_link' => 'required_if:application_type,email|nullable|email',
        ]);

        // Clear the unused application field based on application_type
        if ($validatedData['application_type'] === 'email') {
            $validatedData['application_link'] = null;
        } else {
            $validatedData['email_link'] = null;
        }

        return $validatedData;
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 2;

        while (JobListing::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

}