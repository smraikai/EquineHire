<?php

namespace Database\Factories;

use App\Models\JobListing;
use App\Models\JobListingCategory;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobListingFactory extends Factory
{
    protected $model = JobListing::class;

    public function definition()
    {
        $title = $this->faker->jobTitle;
        return [
            'employer_id' => Employer::factory(),
            'category_id' => JobListingCategory::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title . '-' . $this->faker->unique()->numberBetween(1000, 9999)),
            'description' => $this->faker->paragraphs(3, true),
            'remote_position' => $this->faker->boolean,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract', 'Temporary']),
            'experience_required' => $this->faker->randomElement(['Entry', 'Intermediate', 'Senior', 'Executive']),
            'salary_type' => $this->faker->randomElement(['Hourly', 'Annual']),
            'hourly_rate_min' => $this->faker->randomFloat(2, 10, 100),
            'hourly_rate_max' => $this->faker->randomFloat(2, 100, 200),
            'salary_range_min' => $this->faker->numberBetween(20000, 50000),
            'salary_range_max' => $this->faker->numberBetween(50000, 150000),
            'application_type' => $this->faker->randomElement(['Email', 'URL']),
            'application_link' => $this->faker->url,
            'email_link' => $this->faker->email,
            'is_active' => $this->faker->boolean(80),
            'is_boosted' => $this->faker->boolean(20),
        ];
    }

    // Additional states
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }

    public function boosted()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_boosted' => true,
            ];
        });
    }

}