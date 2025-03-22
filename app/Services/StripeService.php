<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\StripeClient;
use Carbon\Carbon;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Get revenue summary
     *
     * @return array
     */
    public function getRevenueSummary()
    {
        return Cache::remember('stripe_revenue_summary', 3600, function () {
            try {
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;

                return [
                    'today' => $this->getRevenueForDay(),
                    'current_month' => $this->getRevenueForMonth($currentMonth, $currentYear),
                    'previous_month' => $this->getRevenueForMonth($currentMonth - 1 ?: 12, $currentMonth - 1 ? $currentYear : $currentYear - 1),
                    'total' => $this->getTotalRevenue(),
                    'subscription_count' => $this->getActiveSubscriptionCount()
                ];
            } catch (\Exception $e) {
                Log::error('Error fetching revenue data: ' . $e->getMessage());
                return [
                    'today' => 0,
                    'current_month' => 0,
                    'previous_month' => 0,
                    'total' => 0,
                    'subscription_count' => 0
                ];
            }
        });
    }

    /**
     * Get revenue for a specific day
     *
     * @param string|null $date
     * @return float
     */
    public function getRevenueForDay($date = null)
    {
        try {
            $date = $date ? Carbon::parse($date) : Carbon::today();
            $startTimestamp = $date->startOfDay()->timestamp;
            $endTimestamp = $date->endOfDay()->timestamp;

            return $this->getRevenueForPeriod($startTimestamp, $endTimestamp);
        } catch (\Exception $e) {
            Log::error('Error getting daily revenue: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get revenue for a specific month
     *
     * @param int $month
     * @param int $year
     * @return float
     */
    public function getRevenueForMonth($month, $year)
    {
        try {
            $startTimestamp = Carbon::createFromDate($year, $month, 1)->startOfDay()->timestamp;
            $endTimestamp = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay()->timestamp;

            return $this->getRevenueForPeriod($startTimestamp, $endTimestamp);
        } catch (\Exception $e) {
            Log::error('Error getting monthly revenue: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get total revenue
     *
     * @return float
     */
    public function getTotalRevenue()
    {
        try {
            return $this->getRevenueForPeriod(0, Carbon::now()->timestamp);
        } catch (\Exception $e) {
            Log::error('Error getting total revenue: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get revenue for a specific time period
     *
     * @param int $startTimestamp
     * @param int $endTimestamp
     * @return float
     */
    protected function getRevenueForPeriod($startTimestamp, $endTimestamp)
    {
        $charges = $this->stripe->charges->all([
            'created' => [
                'gte' => $startTimestamp,
                'lte' => $endTimestamp
            ],
            'status' => 'succeeded',
            'limit' => 100
        ]);

        $amount = 0;
        foreach ($charges->data as $charge) {
            // Add charge amount converted to dollars
            $amount += $charge->amount / 100;
        }

        return $amount;
    }

    /**
     * Get count of active subscriptions
     *
     * @return int
     */
    public function getActiveSubscriptionCount()
    {
        try {
            $subscriptions = $this->stripe->subscriptions->all([
                'status' => 'active',
                'limit' => 100
            ]);

            return count($subscriptions->data);
        } catch (\Exception $e) {
            Log::error('Error getting active subscription count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get plan distribution
     *
     * @return array
     */
    public function getPlanDistribution()
    {
        try {
            $subscriptions = $this->stripe->subscriptions->all([
                'status' => 'active',
                'limit' => 100,
                'expand' => ['data.plan']
            ]);

            $plans = [];
            foreach ($subscriptions->data as $subscription) {
                $planName = $subscription->plan->nickname ?? 'Unknown';
                if (!isset($plans[$planName])) {
                    $plans[$planName] = 0;
                }
                $plans[$planName]++;
            }

            return $plans;
        } catch (\Exception $e) {
            Log::error('Error getting plan distribution: ' . $e->getMessage());
            return ['No data available' => 0];
        }
    }
}