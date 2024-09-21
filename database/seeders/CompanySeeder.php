<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyDiscipline;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Create 30 companies
        Company::factory()->count(30)->create()->each(function ($company) {
            // Create 1 to 3 job listings for each company
            $company->jobListings()->saveMany(
                \App\Models\JobListing::factory()->count(rand(1, 3))->make()
            );
        });
    }
}