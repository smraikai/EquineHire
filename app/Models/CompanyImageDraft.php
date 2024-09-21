<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyImageDraft extends Model
{
    protected $fillable = ['company_id', 'user_id', 'logo', 'featured_image'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}