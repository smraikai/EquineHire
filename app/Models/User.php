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

    ////////////////////////////////////////////////
    // Check if user can post job based on limits
    ////////////////////////////////////////////////
    public function canCreateJobListing()
    {
        $subscription = $this->subscriptions()
            ->where('stripe_status', 'active')
            ->latest()
            ->first();

        // Use $subscription->type instead of $subscription->name
        $subscriptionType = $subscription ? $subscription->type : null;

        $limits = [
            'basic_plan' => 1,
            'pro_plan' => 5,
            'premium_plan' => 999,
        ];

        $currentCount = $this->jobListings()->count();

        Log::info('User ID: ' . $this->id);
        Log::info('Subscription: ', ['type' => $subscriptionType, 'status' => $subscription ? $subscription->stripe_status : 'None']);
        Log::info('Job Listings: ', ['count' => $currentCount, 'raw' => $this->jobListings()->pluck('id')->toArray()]);
        Log::info('Limit: ' . ($limits[$subscriptionType] ?? 0));

        // Add a default limit for users with active subscriptions but unknown plan
        $limit = $limits[$subscriptionType] ?? ($subscription ? 1 : 0);

        return $currentCount < $limit;
    }

}
