<?php

namespace App\Models;

// Laravel Scout
use Laravel\Scout\Searchable;

// Illumination
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;
    use Searchable;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'website',
        'email',
        'phone',
        'logo',
        'featured_image',
        'post_status',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function photos()
    {
        return $this->hasMany(BusinessPhoto::class, 'job_listing_id');
    }

    // Liknking Together Other Categories
    public function categories()
    {
        return $this->belongsToMany(BusinessCategory::class, 'business_category_associations', 'job_listing_id', 'category_id');
    }
    public function disciplines()
    {
        return $this->belongsToMany(BusinessDiscipline::class, 'business_discipline_associations', 'job_listing_id', 'discipline_id');
    }

    // Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Search Functionality
    public function searchableAs()
    {
        return 'businesses_listings';
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

        // Add discipline IDs
        $array['discipline_ids'] = $this->disciplines->pluck('id')->toArray();

        return $array;
    }


    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        // Only index the model if its post_status is 'Published'
        return $this->post_status === 'Published';
    }
}
