<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListingCategory extends Model
{
    protected $fillable = ['name'];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'job_listing_category_associations');
    }
}