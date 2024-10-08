<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_listing_id',
        'job_seeker_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'resume_path',
    ];

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }

    public function user()
    {
        return $this->jobSeeker->user();
    }
}