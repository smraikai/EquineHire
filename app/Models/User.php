<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{

    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_employer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_employer' => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    public function jobSeeker()
    {
        return $this->hasOne(JobSeeker::class);
    }

    ////////////////////////////////////////////////
    // Check if user can post job based on limits
    ////////////////////////////////////////////////
    public function canCreateJobListing()
    {
        $subscription = $this->subscriptions()
            ->where('stripe_status', 'active')
            ->latest()
            ->first();

        $subscriptionType = $subscription ? $subscription->type : null;

        $limits = [
            'basic_plan' => 1,
            'pro_plan' => 5,
            'unlimited_plan' => 999,
        ];

        $currentCount = $this->jobListings()
            ->where('is_active', true)
            ->count();

        $limit = $limits[$subscriptionType] ?? ($subscription ? 1 : 0);

        return $currentCount < $limit;  // Strict less than for new listings
    }

    public function canRestoreJobListing()
    {
        return $this->checkJobListingLimit(1);
    }

    private function checkJobListingLimit($additionalCount = 0)
    {
        $subscription = $this->subscriptions()
            ->where('stripe_status', 'active')
            ->latest()
            ->first();

        $subscriptionType = $subscription ? $subscription->type : null;

        $limits = [
            'basic_plan' => 1,
            'pro_plan' => 5,
            'unlimited_plan' => 999,
        ];

        $currentCount = $this->jobListings()
            ->where('is_active', true)
            ->count();

        $limit = $limits[$subscriptionType] ?? ($subscription ? 1 : 0);

        return ($currentCount + $additionalCount) <= $limit;
    }

}
