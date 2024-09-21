<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessPhoto extends Model
{
    // Define the table name explicitly if needed
    protected $table = 'business_photos';
    protected $fillable = [
        'job_listing_id',
        'path'
    ];

    // Define the relationship with the Business model
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'job_listing_id');
    }
}
