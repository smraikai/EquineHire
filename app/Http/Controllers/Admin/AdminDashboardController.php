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

    public function jobListings(Request $request)
    {
        $query = JobListing::with('employer');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by boosted status
        if ($request->filled('boosted')) {
            if ($request->boosted === 'yes') {
                $query->where('is_boosted', true);
            } elseif ($request->boosted === 'no') {
                $query->where('is_boosted', false);
            }
        }

        // Filter by employer
        if ($request->filled('employer')) {
            $query->whereHas('employer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employer . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in title and description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $jobListings = $query->latest()->paginate(15)->appends($request->query());
        
        return view('admin.job-listings.index', compact('jobListings'));
    }

    public function employers(Request $request)
    {
        $query = Employer::with('user');

        // Search in name and description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Filter by subscription status
        if ($request->filled('subscription_status')) {
            if ($request->subscription_status === 'active') {
                $query->whereHas('user', function ($q) {
                    $q->whereHas('subscriptions', function ($sq) {
                        $sq->where('stripe_status', 'active');
                    });
                });
            } elseif ($request->subscription_status === 'inactive') {
                $query->whereHas('user', function ($q) {
                    $q->whereDoesntHave('subscriptions', function ($sq) {
                        $sq->where('stripe_status', 'active');
                    });
                });
            } elseif ($request->subscription_status === 'no_user') {
                $query->whereNull('user_id');
            }
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', "%{$request->location}%")
                  ->orWhere('state', 'like', "%{$request->location}%")
                  ->orWhere('country', 'like', "%{$request->location}%");
            });
        }

        // Filter by job listings count
        if ($request->filled('job_listings')) {
            if ($request->job_listings === 'has_listings') {
                $query->has('jobListings');
            } elseif ($request->job_listings === 'no_listings') {
                $query->doesntHave('jobListings');
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $employers = $query->latest()->paginate(15)->appends($request->query());
        
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

    public function updateJobListingCreatedAt(Request $request, JobListing $jobListing)
    {
        $validated = $request->validate([
            'created_at' => ['required', 'date'],
        ]);

        $jobListing->created_at = $validated['created_at'];
        $jobListing->save();

        return back()->with('success', 'Job listing creation date updated successfully.');
    }
}