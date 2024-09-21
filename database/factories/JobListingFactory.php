<?php

namespace Database\Factories;

use App\Models\JobListing;
use App\Models\Company;
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
            'company_id' => Company::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle,
            'slug' => Str::slug($title . '-' . $this->faker->unique()->numberBetween(1000, 9999)),
            'description' => $this->faker->paragraphs(3, true),
            'remote_position' => $this->faker->boolean(),
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract', 'Temporary', 'Internship']),
            'experience_required' => $this->faker->randomElement(['Entry-level', 'Mid-level', 'Senior', 'Executive']),
            'salary_type' => $this->faker->randomElement(['Hourly', 'Annual']),
            'hourly_rate_min' => $this->faker->randomFloat(2, 10, 50),
            'hourly_rate_max' => $this->faker->randomFloat(2, 51, 100),
            'salary_range_min' => $this->faker->randomFloat(2, 30000, 60000),
            'salary_range_max' => $this->faker->randomFloat(2, 61000, 150000),
            'application_type' => $this->faker->randomElement(['Link', 'Email']),
            'application_link' => $this->faker->url,
            'email_link' => $this->faker->safeEmail,
            'is_active' => $this->faker->boolean(80),
            'is_boosted' => $this->faker->boolean(20),
            'is_sticky' => $this->faker->boolean(10),
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

    public function sticky()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_sticky' => true,
            ];
        });
    }
}