<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Boarding' => [],
            'Breeding' => [],
            'Chiropractic' => [],
            'Dentistry' => [],
            'Farrier' => [],
            'Lessons' => [],
            'Massage Therapy' => [],
            'Nutritionist' => [],
            'Rehabilitation' => [],
            'Retail' => [],
            'Retirement' => [],
            'Sales and Consignment' => [],
            'Summer Camp' => [],
            'Training' => [],
            'Transport' => [],
            'Veterinarian' => [],
            'Other' => [],
            // Add additional categories here
            'Horse Hotel' => [],
            'Theraputic Riding' => [],
            'Equine Assisted Services' => [],
        ];

        foreach ($categories as $category => $subcategories) {
            // Check if the main category already exists
            $existingCategory = DB::table('business_categories')->where('name', $category)->first();

            if (! $existingCategory) {
                $mainCategoryId = DB::table('business_categories')->insertGetId([
                    'name' => $category,
                    'parent_id' => null
                ]);

                // Check if subcategories is an array before trying to iterate
                if (is_array($subcategories)) {
                    foreach ($subcategories as $subcategory) {
                        DB::table('business_categories')->insert([
                            'name' => $subcategory,
                            'parent_id' => $mainCategoryId
                        ]);
                    }
                }
            }
        }
    }
}
