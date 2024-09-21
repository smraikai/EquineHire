<?php

namespace App\Models;

// Illumination
use Illuminate\Database\Eloquent\Model;

class BusinessImageDraft extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = ['job_listing_id', 'user_id', 'created_at', 'updated_at'];


    // Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
