<?php

namespace App\Http\Controllers\Employer;
use App\Http\Controllers\Controller;

use App\Http\Controllers\SEOController;
use App\Models\Employer;
use App\Models\JobApplication;
use Illuminate\Http\Request;

// Stripe Integration for GA Tracking
use Stripe\Stripe;
use Stripe\Price;

class EmployerController extends Controller
{

    /////////////////////////////////////////////////////////////
    // Set SEO controller
    /////////////////////////////////////////////////////////////
    protected $seoController;

    public function __construct(SEOController $seoController)
    {
        $this->seoController = $seoController;
    }

    /////////////////////////////////////////////////////////////
    // Employer Public Page
    /////////////////////////////////////////////////////////////
    public function show(Employer $employer)
    {
        $this->seoController->setEmployerSEO($employer);
        return view('employers.show', compact('employer'));
    }

    /////////////////////////////////////////////////////////////
    // Employer Dashboard
    /////////////////////////////////////////////////////////////
    public function index(Request $request)
    {
        $user = auth()->user();
        $employer = $user->employer;
        $jobListings = $employer ? $employer->jobListings()->latest()->take(5)->get() : collect();

        // Add this section to get recent applications
        $recentApplications = collect();
        if ($employer) {
            $recentApplications = JobApplication::whereIn('job_listing_id', $employer->jobListings->pluck('id'))
                ->latest()
                ->take(10)
                ->get();
        }

        // Check if the user is a new subscriber. If so, pass off info to the DataLayer
        if ($request->query('subscription_completed')) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $subscription = $user->subscription('default');

            $amount = null;
            if ($subscription) {
                $price = Price::retrieve($subscription->stripe_price);
                $amount = $price->unit_amount / 100; // Convert cents to dollars
            }

            return view('dashboard.index', compact('user', 'employer', 'jobListings', 'subscription', 'amount', 'recentApplications'));
        }

        return view('dashboard.index', compact('user', 'employer', 'jobListings', 'recentApplications'));
    }
}
