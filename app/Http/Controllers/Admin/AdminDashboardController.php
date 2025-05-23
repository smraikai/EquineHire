<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobListing;
use App\Models\JobApplication;
use App\Models\Employer;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->middleware('admin');
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        // Get statistics for the admin dashboard
        $stats = [
            'total_users' => User::count(),
            'employers' => Employer::count(),
            'job_listings' => JobListing::count(),
            'applications' => JobApplication::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_job_listings' => JobListing::with('employer')->latest()->take(5)->get(),
            'recent_applications' => JobApplication::with(['jobListing', 'jobSeeker.user'])->latest()->take(10)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function revenue()
    {
        // Get detailed revenue data
        $revenueSummary = $this->stripeService->getRevenueSummary();
        $planDistribution = $this->stripeService->getPlanDistribution();

        // Get monthly revenue for the last 12 months
        $monthlyRevenue = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('M Y');
            $revenue = $this->stripeService->getRevenueForMonth($date->month, $date->year);

            $monthlyRevenue[] = $revenue;
            $labels[] = $month;
        }

        // Get active subscriptions by plan
        $subscriptionsByPlan = $planDistribution;

        // Get user subscription data
        $recentSubscriptions = DB::table('subscriptions')
            ->join('users', 'subscriptions.user_id', '=', 'users.id')
            ->select('subscriptions.*', 'users.name', 'users.email')
            ->where('subscriptions.stripe_status', 'active')
            ->orderBy('subscriptions.created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.revenue.index', compact(
            'revenueSummary',
            'planDistribution',
            'monthlyRevenue',
            'labels',
            'subscriptionsByPlan',
            'recentSubscriptions'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function jobListings()
    {
        $jobListings = JobListing::with('employer.user')->latest()->paginate(15);
        return view('admin.job-listings.index', compact('jobListings'));
    }

    public function employers()
    {
        $employers = Employer::with('user')->latest()->paginate(15);
        return view('admin.employers.index', compact('employers'));
    }

    public function applications()
    {
        $applications = JobApplication::with(['jobListing', 'jobSeeker.user'])->latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    public function showApplication(JobApplication $application)
    {
        // Eager load all the necessary relationships
        $application->load(['jobListing.employer', 'jobSeeker.user']);
        return view('admin.applications.show', compact('application'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,reviewed,contacted,rejected'],
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', 'Application status updated successfully.');
    }

    public function updatePublishDate(Request $request, JobListing $jobListing)
    {
        $validated = $request->validate([
            'publish_date' => ['required', 'date'],
        ]);

        $jobListing->update(['created_at' => $validated['publish_date']]);

        return back()->with('success', 'Job listing publish date updated successfully.');
    }
}
