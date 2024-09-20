<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        // Seed businesses
        $this->seedBusinesses();
    }

    private function seedBusinesses(): void
    {
        Business::factory()
            ->count(100) // Create 100 businesses
            ->create();
    }
}
