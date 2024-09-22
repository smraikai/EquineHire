<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;
use App\Models\Company;
use App\Models\JobListingCategory;

class JobListingSeeder extends Seeder
{
    public function run()
    {
        $companies = Company::all();
        $categories = JobListingCategory::all();

        foreach ($companies as $company) {
            JobListing::factory()->count(rand(1, 5))->create([
                'company_id' => $company->id,
                'user_id' => $company->user_id,
            ])->each(function ($jobListing) use ($categories) {
                $jobListing->categories()->attach(
                    $categories->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
        }
    }
}