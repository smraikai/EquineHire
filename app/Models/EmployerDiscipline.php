<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerDiscipline extends Model
{
    protected $fillable = ['name'];

    public function employers()
    {
        return $this->belongsToMany(Employer::class, 'employer_discipline_associations');
    }
}