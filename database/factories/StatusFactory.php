<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(),
            'type' => $this->faker->randomElement(['placement', 'journal', 'guidance', 'assignment', 'assessment']),
            'label' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'priority' => $this->faker->numberBetween(0, 10),
            'flag' => $this->faker->boolean(),
            'is_default' => $this->faker->boolean(),
            'color' => $this->faker->hexColor(),
            'icon' => $this->faker->randomElement(['success', 'info', 'warning', 'error']),
        ];
    }
}
