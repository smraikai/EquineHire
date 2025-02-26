<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Employer extends Model
{
    use HasFactory, Searchable;

    protected $table = 'employers';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'website',
        'street_address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'logo',
        'featured_image',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }

    public function activeJobListings()
    {
        return $this->jobListings()->where('status', 'active');
    }

    public function inactiveJobListings()
    {
        return $this->jobListings()->where('status', 'inactive');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function searchableAs()
    {
        return 'employers';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // Make sure the name is included in the searchable array
        $array['name'] = $this->name;

        if (isset($array['latitude']) && isset($array['longitude'])) {
            $array['_geoloc'] = [
                'lat' => (float) $array['latitude'],
                'lng' => (float) $array['longitude']
            ];
        }

        return $array;
    }

    public function getAlgoliaSettings()
    {
        return [
            'searchableAttributes' => [
                'name',
                'description',
                'city',
                'state',
            ],
        ];
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    //////////////////////////////////////////////////////
    // Helpers
    //////////////////////////////////////////////////////
    public static function employerProfileCheck($user)
    {
        return $user && $user->employer;
    }
}