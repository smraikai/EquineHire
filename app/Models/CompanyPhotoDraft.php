<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPhotoDraft extends Model
{
    protected $fillable = ['company_id', 'path'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}