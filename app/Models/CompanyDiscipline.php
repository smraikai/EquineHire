<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDiscipline extends Model
{
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_discipline_associations');
    }
}