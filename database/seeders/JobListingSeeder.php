<?php

namespace Database\Seeders;

use App\Models\JobListing;
use App\Models\JobListingCategory;
use App\Models\JobListingDiscipline;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    public function run()
    {
        // Create 50 job listings
        JobListing::factory()->count(50)->create()->each(function ($jobListing) {
            // Attach random categories (1 to 3)
            $categories = JobListingCategory::inRandomOrder()->take(rand(1, 3))->get();
            $jobListing->categories()->attach($categories);

            // Attach random disciplines (1 to 3)
            $disciplines = JobListingDiscipline::inRandomOrder()->take(rand(1, 3))->get();
            $jobListing->disciplines()->attach($disciplines);
        });

        // Create 10 boosted job listings
        JobListing::factory()->count(10)->boosted()->create()->each(function ($jobListing) {
            $categories = JobListingCategory::inRandomOrder()->take(rand(1, 3))->get();
            $jobListing->categories()->attach($categories);

            $disciplines = JobListingDiscipline::inRandomOrder()->take(rand(1, 3))->get();
            $jobListing->disciplines()->attach($disciplines);
        });

        // Create 5 sticky job listings
        JobListing::factory()->count(5)->sticky()->create()->each(function ($jobListing) {
            $categories = JobListingCategory::inRandomOrder()->take(rand(1, 3))->get();
            $jobListing->categories()->attach($categories);

            $disciplines = JobListingDiscipline::inRandomOrder()->take(rand(1, 3))->get();
            $jobListing->disciplines()->attach($disciplines);
        });
    }
}