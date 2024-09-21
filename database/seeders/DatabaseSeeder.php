<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JobListingCategoriesSeeder::class,
            CompanySeeder::class, // Add this line
            JobListingSeeder::class,
        ]);
    }
}
