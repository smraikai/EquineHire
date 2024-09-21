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

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // Ensure the 'id' is used as 'objectID'
        $array['objectID'] = $this->getKey();
        // Add state as a facet
        $array['state'] = $this->state;

        // Only add _geoloc if latitude and longitude are not null
        if ($this->latitude && $this->longitude) {
            $array['_geoloc'] = [
                'lat' => $this->latitude,
                'lng' => $this->longitude,
            ];
        }

        // Add category IDs
        $array['category_ids'] = $this->categories->pluck('id')->toArray();

        // Add custom ranking attribute for sticky posts
        $array['sticky_rank'] = $this->is_sticky ? 1 : 0;

        return $array;
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

    public function getAlgoliaSettings()
    {
        return [
            'attributesForFaceting' => ['state'],
        ];
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