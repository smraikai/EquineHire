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
        'status',
    ];

    const STATUS_NEW = 'new';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_REJECTED = 'rejected';

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

    public function employer()
    {
        return $this->jobListing->employer();
    }

    public function getStatusBadgeColor()
    {
        return match ($this->status) {
            self::STATUS_NEW => 'bg-green-50 text-green-700',
            self::STATUS_REVIEWED => 'bg-yellow-50 text-yellow-700',
            self::STATUS_CONTACTED => 'bg-blue-50 text-blue-700',
            self::STATUS_REJECTED => 'bg-red-50 text-red-700',
            default => 'bg-gray-50 text-gray-700',
        };
    }
}