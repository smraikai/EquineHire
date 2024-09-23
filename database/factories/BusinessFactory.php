<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->employer;
        $slug = Str::slug($name);

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'state_slug' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'website' => $this->faker->url,
            'email' => $this->faker->employerEmail,
            'phone' => $this->faker->phoneNumber,
            'logo' => $this->faker->imageUrl,
            'featured_image' => $this->faker->imageUrl,
            'post_status' => 'Published',
        ];
    }

    /**
     * Configure the factory to include default geolocation.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withGeolocation()
    {
        return $this->state(function (array $attributes) {
            return [
                'latitude' => $this->faker->latitude($min = -90, $max = 90),
                'longitude' => $this->faker->longitude($min = -180, $max = 180)
            ];
        });
    }
}