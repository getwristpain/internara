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
            'name'           => $this->faker->company(),
            'logo_path'      => $this->faker->imageUrl(200, 200, 'education', true, 'School Logo'),
            'address'        => $this->faker->address(),
            'email'          => $this->faker->unique()->companyEmail(),
            'phone'          => $this->faker->optional()->phoneNumber(),
            'fax'            => $this->faker->optional()->phoneNumber(),
            'website'        => $this->faker->url(),
            'principal_name' => $this->faker->name(),
        ];
    }
}
