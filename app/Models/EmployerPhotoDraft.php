<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPhotoDraft extends Model
{
    protected $fillable = ['employer_id', 'path'];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}