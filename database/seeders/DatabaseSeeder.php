<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Call other seeders here
            BusinessSeeder::class,
            BusinessCategoriesSeeder::class,
            BusinessDisciplineSeeder::class,
        ]);
    }
}
