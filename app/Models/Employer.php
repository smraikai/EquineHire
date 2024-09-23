<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Model
{
    use HasFactory, Searchable;

    protected $table = 'employers';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'website',
        'city',
        'state',
        'logo',
    ];

    protected $casts = [

    ];

    public function photos()
    {
        return $this->hasMany(EmployerPhoto::class);
    }

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

        if ($this->latitude && $this->longitude) {
            $array['_geoloc'] = [
                'lat' => $this->latitude,
                'lng' => $this->longitude,
            ];
        }

        return $array;
    }
}