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
            'code'        => strtoupper($this->faker->unique()->bothify('DEP###')),
            'name'        => $this->faker->word() . ' Department',
            'description' => $this->faker->sentence(),
            'school_id'   => School::factory(),
        ];
    }
}
