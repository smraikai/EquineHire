<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\EmployerDiscipline;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        // Create 30 employers
        Employer::factory()->count(30)->create()->each(function ($employer) {
            // Create 1 to 3 job listings for each employer
            $employer->jobListings()->saveMany(
                \App\Models\JobListing::factory()->count(rand(1, 3))->make()
            );
        });
    }
}