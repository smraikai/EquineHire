<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobListingCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Groom Jobs',
            'Health & Veterinary Jobs',
            'Manager Jobs',
            'Office Jobs',
            'Rider Jobs',
            'Trainer Jobs',
            'Other Jobs',
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category);

            // Check if the category already exists
            if (!DB::table('job_listing_categories')->where('slug', $slug)->exists()) {
                DB::table('job_listing_categories')->insert([
                    'name' => $category,
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}