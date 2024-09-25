<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\JobListing;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        Employer::factory()
            ->count(30)
            ->has(JobListing::factory()->count(rand(1, 3)))
            ->create();
    }
}