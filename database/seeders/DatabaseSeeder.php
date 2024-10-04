<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JobListingCategoriesSeeder::class,
            // EmployerSeeder::class,
            // JobListingSeeder::class,
            // JobListingsSeeder::class, (old EQH listings)
        ]);
    }
}