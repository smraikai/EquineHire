<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, Searchable;

    protected $table = 'company';

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
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function photos()
    {
        return $this->hasMany(CompanyPhoto::class);
    }

    public function disciplines()
    {
        return $this->belongsToMany(CompanyDiscipline::class, 'company_discipline_associations');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }

    public function searchableAs()
    {
        return 'companies';
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

        $array['category_ids'] = $this->categories->pluck('id')->toArray();
        $array['discipline_ids'] = $this->disciplines->pluck('id')->toArray();

        return $array;
    }
}