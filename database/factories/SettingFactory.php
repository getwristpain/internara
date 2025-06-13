<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['string', 'boolean', 'integer', 'float', 'array', 'json', 'email', 'url'];
        $type = $this->faker->randomElement($types);

        $value = match ($type) {
            'boolean' => $this->faker->boolean(),
            'integer' => $this->faker->numberBetween(1, 100),
            'float'   => $this->faker->randomFloat(2, 1, 100),
            'array'   => [$this->faker->word(), $this->faker->word()],
            'json'    => json_encode(['foo' => 'bar']),
            'email'   => $this->faker->safeEmail(),
            'url'     => $this->faker->url(),
            default   => $this->faker->sentence(),
        };

        return [
            'key'         => $this->faker->unique()->word(),
            'value'       => $value,
            'type'        => $type,
            'label'       => $this->faker->words(2, true),
            'category'    => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
