<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessDiscipline extends Model
{
    protected $fillable = ['name'];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_discipline_associations');
    }
}