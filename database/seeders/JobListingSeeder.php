<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;
use App\Models\Employer;
use App\Models\JobListingCategory;

class JobListingSeeder extends Seeder
{
    public function run()
    {
        $employers = Employer::all();
        $categories = JobListingCategory::all();

        foreach ($employers as $employer) {
            JobListing::factory()->count(rand(1, 5))->create([
                'employer_id' => $employer->id,
                'user_id' => $employer->user_id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}