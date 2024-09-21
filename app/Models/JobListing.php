<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
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
        'latitude',
        'longitude',
        'post_status',
    ];

    protected $casts = [
        'remote_position' => 'boolean',
        'is_active' => 'boolean',
        'is_boosted' => 'boolean',
        'is_sticky' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
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

    // Search Functionality
    public function searchableAs()
    {
        return 'job_listings';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // Only add _geoloc if latitude and longitude are not null
        if ($this->latitude && $this->longitude) {
            $array['_geoloc'] = [
                'lat' => $this->latitude,
                'lng' => $this->longitude,
            ];
        }

        // Add category IDs
        $array['category_ids'] = $this->categories->pluck('id')->toArray();

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

    // ... (keep any other existing methods)
}