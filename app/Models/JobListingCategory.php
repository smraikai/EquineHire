<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListingCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }
}