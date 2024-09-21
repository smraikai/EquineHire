<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobListingCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Groom Jobs' => [],
            'Health & Veterinary Jobs' => [],
            'Manager Jobs' => [],
            'Office Jobs' => [],
            'Rider Jobs' => [],
            'Trainer Jobs' => [],
            'Other Jobs' => [],
        ];

        foreach ($categories as $category => $subcategories) {
            // Check if the main category already exists
            $existingCategory = DB::table('job_listing_categories')->where('name', $category)->first();

            if (!$existingCategory) {
                $mainCategoryId = DB::table('job_listing_categories')->insertGetId([
                    'name' => $category,
                    'parent_id' => null
                ]);

                // Check if subcategories is an array before trying to iterate
                if (is_array($subcategories)) {
                    foreach ($subcategories as $subcategory) {
                        DB::table('job_listing_categories')->insert([
                            'name' => $subcategory,
                            'parent_id' => $mainCategoryId
                        ]);
                    }
                }
            }
        }
    }
}
