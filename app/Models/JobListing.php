<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class JobListing extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'employer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'street_address',
        'remote_position',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'job_type',
        'experience_required',
        'salary_type',
        'hourly_rate_min',
        'hourly_rate_max',
        'salary_range_min',
        'salary_range_max',
        'application_type',
        'application_link',
        'email_link',
        'is_active',
        'is_boosted',
        'boost_expires_at',
        'views',
        'currency',  // Add this line
    ];

    protected $casts = [
        'remote_position' => 'boolean',
        'is_active' => 'boolean',
        'is_boosted' => 'boolean',
        'hourly_rate_min' => 'decimal:2',
        'hourly_rate_max' => 'decimal:2',
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
    ];

    // Currencies
    public const CURRENCIES = [
        'USD' => [
            'code' => 'USD',
            'symbol' => '$',
            'name' => 'US Dollar'
        ],
        'CAD' => [
            'code' => 'CAD',
            'symbol' => '$',
            'name' => 'Canadian Dollar'
        ],
        'EUR' => [
            'code' => 'EUR',
            'symbol' => '€',
            'name' => 'Euro'
        ],
        'GBP' => [
            'code' => 'GBP',
            'symbol' => '£',
            'name' => 'British Pound'
        ],
        'CHF' => [
            'code' => 'CHF',
            'symbol' => 'CHF',
            'name' => 'Swiss Franc'
        ]
    ];

    // Add this method to get default currency
    public static function getDefaultCurrency()
    {
        return 'USD';
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class)->withDefault([
            'name' => 'Unknown Employer',
            'logo' => null,
        ]);
    }

    public function category()
    {
        return $this->belongsTo(JobListingCategory::class, 'category_id');
    }

    // Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    ///////////////////////////////////////////////////////////////
    // Search / Algolia Settings
    ///////////////////////////////////////////////////////////////
    public function searchableAs()
    {
        return 'job_listings';
    }
    public function getScoutKey()
    {
        return $this->id;
    }
    // Define what is searchable or not
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array['objectID'] = $this->getKey();

        if ($this->latitude && $this->longitude) {
            $array['_geoloc'] = [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude
            ];
        }

        $array['country'] = $this->country ? strtoupper(trim($this->country)) : null;

        $array['boosted_rank'] = $this->is_boosted ? 9001 : 0;
        $array['employer_name'] = $this->employer->name;
        $array['category_ids'] = [$this->category_id];
        $array['state'] = $this->state ? trim($this->state) : null;
        $array['city'] = $this->city ? trim($this->city) : null;
        $array['job_type'] = $this->job_type;
        $array['experience_required'] = $this->experience_required;
        $array['salary_type'] = $this->salary_type;
        $array['remote_position'] = (bool) $this->remote_position;

        return array_filter($array, function ($value) {
            return ! is_null($value);
        });
    }

    public function getAlgoliaSettings()
    {
        return [
            'searchableAttributes' => [
                'title',
                'description',
                'employer_name',
                'city',
                'country'
            ],
            'attributesForFaceting' => [
                'searchable(city)',
                'searchable(country)',
                'job_type',
                'experience_required',
                'salary_type',
                'filterOnly(category_ids)',
                'filterOnly(remote_position)',
                'filterOnly(is_active)'
            ],
            'customRanking' => [
                'desc(boosted_rank)',
                'desc(created_at)'
            ]
        ];
    }

    protected static function booted()
    {
        // Ensure currency is set before creating the JobListing
        static::creating(function ($jobListing) {
            if (empty($jobListing->currency)) {
                $jobListing->currency = self::getDefaultCurrency();
            }
        });

        // Wrap searchable() calls in try-catch to avoid interruptions
        // Use 'saved' event for both created and updated to ensure Algolia sync is consistent
        static::saved(function ($jobListing) {
            try {
                if ($jobListing->shouldBeSearchable()) {
                    $jobListing->searchable(); // Re-index if it should be searchable
                } else {
                    // If it should not be searchable, ensure it's removed from the index
                    $jobListing->unsearchable();
                }
            } catch (\Exception $e) {
                Log::error('Algolia indexing/unindexing failed for JobListing ID '.$jobListing->id.': '.$e->getMessage());
            }
        });

        // Add an observer for the updating event
        static::updating(function ($jobListing) {
            // If trying to set is_active to true, check subscription status
            if ($jobListing->isDirty('is_active') && $jobListing->is_active && ! $jobListing->canBeActive()) {
                $jobListing->is_active = false;
            }
        });
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        // Only index the model if it's active AND the user has an active subscription
        return $this->is_active === true && $this->user && $this->user->hasActiveSubscription();
    }

    /**
     * Get unique countries from active job listings.
     *
     * @return array
     */
    public static function getUniqueCountries()
    {
        return self::where('is_active', true)
            ->whereNotNull('country')
            ->distinct()
            ->pluck('country')
            ->sort()
            ->values()
            ->toArray();
    }

    ///////////////////////////////////////////////////////////////
    // Job Applications
    ///////////////////////////////////////////////////////////////
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function archive()
    {
        try {
            // First remove from Algolia before changing the status
            // This ensures we can still find the record in Algolia to delete it
            $this->unsearchable();

            // Now update the database record
            $this->is_active = false;
            $this->save();

            // Double-check removal using the Algolia client directly
            try {
                $client = \Algolia\AlgoliaSearch\SearchClient::create(
                    config('scout.algolia.id'),
                    config('scout.algolia.secret')
                );
                $index = $client->initIndex($this->searchableAs());
                $index->deleteObject($this->getScoutKey());

                Log::info("Job listing forcefully removed from Algolia: {$this->id}");
            } catch (\Exception $e) {
                Log::error("Error during force removal from Algolia: ".$e->getMessage());
            }

            Log::info("Job listing archived successfully: {$this->id} - {$this->title}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to archive job listing {$this->id}: ".$e->getMessage());
            return false;
        }
    }

    public function unarchive()
    {
        if (! $this->canBeActive()) {
            return false;
        }

        $this->is_active = true;
        $this->save();
        $this->searchable();

        return true;
    }

    public function isArchived()
    {
        return ! $this->is_active;
    }

    /**
     * Check if job listing can be active based on subscription status
     *
     * @return bool
     */
    public function canBeActive()
    {
        if (! $this->user) {
            return false;
        }

        return $this->user->subscriptions()
            ->where('stripe_status', 'active')
            ->exists();
    }

    /**
     * Handle job listing activation with subscription check
     *
     * @return bool
     */
    public function activate()
    {
        if (! $this->canBeActive()) {
            return false;
        }

        $this->is_active = true;
        $this->save();
        $this->searchable();

        return true;
    }
}
