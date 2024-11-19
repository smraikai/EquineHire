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
                'lat' => (float) $this->latitude,  // Cast to float
                'lng' => (float) $this->longitude  // Cast to float
            ];
        }

        $array['boosted_rank'] = $this->is_boosted ? 9001 : 0;

        // Include employer name
        $array['employer_name'] = $this->employer->name;

        // Add new facets
        $array['category_ids'] = [$this->category_id];
        $array['state'] = $this->state ? trim($this->state) : null;
        $array['job_type'] = $this->job_type;
        $array['experience_required'] = $this->experience_required;
        $array['salary_type'] = $this->salary_type;
        $array['remote_position'] = (bool) $this->remote_position;

        return $array;
    }

    public function getAlgoliaSettings()
    {
        return [
            'attributesForFaceting' => [
                'searchable(city)',
                'searchable(state)',
                'job_type',
                'experience_required',
                'salary_type',
                'filterOnly(category_ids)',
                'filterOnly(remote_position)'
            ],
        ];
    }

    protected static function booted()
    {
        static::created(function ($jobListing) {
            $jobListing->searchable();
        });

        static::updated(function ($jobListing) {
            $jobListing->searchable();
        });
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        // Only index the model if it's active
        return $this->is_active === true;
    }

    /**
     * Get unique states from active job listings.
     *
     * @return array
     */
    public static function getUniqueStates()
    {
        return self::where('is_active', true)
            ->whereNotNull('state')
            ->distinct()
            ->pluck('state')
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
        $this->is_active = false;
        $this->save();

        // Since shouldBeSearchable() returns false when inactive,
        // this will remove it from Algolia
        $this->unsearchable();
    }

    public function unarchive()
    {
        $this->is_active = true;
        $this->save();

        // Make searchable again if activated
        $this->searchable();
    }

    public function isArchived()
    {
        return !$this->is_active;
    }
}