<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->company,
            'email'             => $this->faker->unique()->safeEmail,
            'telp'              => $this->faker->phoneNumber,
            'fax'               => $this->faker->phoneNumber,
            'address'           => $this->faker->address,
            'principal_name'    => $this->faker->name,
            'website'           => $this->faker->url,
            'logo_path'         => $this->faker->imageUrl(640, 480, 'business', true, 'logo', true),
        ];
    }
}
