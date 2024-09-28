<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;

class JobListingBoostController extends Controller
{
    public function boost(Request $request, JobListing $jobListing)
    {
        if ($request->user()->id !== $jobListing->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = $request->user();
        $boostPrice = config('job_boost.price');

        try {
            $checkout = $user->checkoutCharge($boostPrice, "Boost Job Listing: {$jobListing->title}", 1, [
                'success_url' => route('job-listing.boost.success', ['jobListing' => $jobListing->id]),
                'cancel_url' => route('employers.job-listings.index', ['job_slug' => $jobListing->slug, 'id' => $jobListing->id]),
            ]);

            return response()->json(['checkout_url' => $checkout->url]);
        } catch (IncompletePayment $exception) {
            return redirect()->route('cashier.payment', [$exception->payment->id, 'redirect' => route('employers.job-listings.index')]);
        } catch (\Exception $e) {
            Log::error('Job boost checkout failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to create checkout session'], 500);
        }
    }

    public function handleSuccessfulBoost(Request $request, JobListing $jobListing)
    {
        Log::info('handleSuccessfulBoost method called', ['job_listing_id' => $jobListing->id]);

        try {
            $updated = $jobListing->update(['is_boosted' => true]);
            Log::info('Job listing boost update attempt', [
                'job_listing_id' => $jobListing->id,
                'update_success' => $updated
            ]);

            if ($updated) {
                return redirect()->route('employers.job-listings.index', $jobListing->id)
                    ->with('success', 'Your job listing has been successfully boosted!');
            } else {
                Log::error('Failed to update job listing boost status', ['job_listing_id' => $jobListing->id]);
                return redirect()->route('employers.job-listings.index', $jobListing->id)
                    ->with('error', 'There was an error boosting your job listing. Please contact support.');
            }
        } catch (\Exception $e) {
            Log::error('Job boost failed: ' . $e->getMessage(), [
                'exception' => $e,
                'job_listing_id' => $jobListing->id
            ]);
            return redirect()->route('employers.job-listings.index', $jobListing->id)
                ->with('error', 'There was an error boosting your job listing. Please contact support.');
        }
    }
}