<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'description',
        'remote_position',
        'city',
        'state',
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
        'is_sticky',
    ];

    protected $casts = [
        'remote_position' => 'boolean',
        'is_active' => 'boolean',
        'is_boosted' => 'boolean',
        'is_sticky' => 'boolean',
        'hourly_rate_min' => 'decimal:2',
        'hourly_rate_max' => 'decimal:2',
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function photos()
    {
        return $this->hasMany(JobListingPhoto::class);
    }

    public function categories()
    {
        return $this->belongsToMany(JobListingCategory::class, 'job_listing_category_associations');
    }

    public function disciplines()
    {
        return $this->belongsToMany(JobListingDiscipline::class, 'job_listing_discipline_associations');
    }

    // Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    ///////////////////////////////////////////////////////////////
    // Algolia Settings
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
                'lat' => $this->latitude,
                'lng' => $this->longitude,
            ];
        }

        $array['sticky_rank'] = $this->is_sticky ? 1 : 0;

        // Add new facets
        $array['category_ids'] = array_map('strval', $this->categories->pluck('id')->toArray());
        $array['state'] = $this->state;
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
                'state',
                'job_type',
                'experience_required',
                'salary_type',
                'remote_position',
                'filterOnly(category_ids)',
                'filterOnly(remote_position)'
            ],
        ];
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
}