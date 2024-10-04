<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone_number',
        'location',
        'profile_picture_url',
        'bio',
        'resume_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}