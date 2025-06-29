<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id'     => School::factory(),
            'name'          => $this->faker->unique()->word() . ' Department',
            'code'          => $this->faker->unique()->bothify('??-###'),
            'description'   => $this->faker->optional()->paragraph(2),
        ];
    }
}
