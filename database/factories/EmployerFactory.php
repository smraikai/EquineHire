<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployerFactory extends Factory
{
    protected $model = Employer::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company,
            'description' => $this->faker->paragraphs(2, true),
            'website' => $this->faker->url,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'logo' => $this->faker->imageUrl(200, 200, 'business'),
            'featured_image' => $this->faker->imageUrl(1920, 1080, 'business'),
        ];
    }
}