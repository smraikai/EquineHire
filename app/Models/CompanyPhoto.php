<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPhoto extends Model
{
    protected $fillable = [
        'company_id',
        'path'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}