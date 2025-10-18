<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        $address = fake()->address();
        [$city, $postal_code] = $this->getCityAndPostalCode($address);

        $name = "Sekolah Kejuruan {$city}";

        preg_match_all('/\b\w/', $name, $matches);
        $initials = Str::lower(implode('', $matches[0]));

        return [
            'name' => $name,
            'principal_name' => fake()->name(),
            'address' => $address,
            'postal_code' => $postal_code,
            'email' => "{$initials}-school@example.com",
            'phone' => fake()->unique()->phoneNumber(),
            'fax' => fake()->unique()->phoneNumber(),
            'website' => 'https://'.$initials.'-school.example.com',
        ];
    }

    protected function getCityAndPostalCode(string $address): array
    {
        $cityLine = $this->extractAndGetCityLine($address);

        $postalCode = $cityLine->pop();
        $city = $cityLine->implode(' ');

        return [$city, $postalCode];
    }

    protected function extractAndGetCityLine(string $address): Collection
    {
        $dirty = trim(str($address)->explode(',')->filter()->slice(-2, 1)->first());
        return str($dirty)->explode(' ')->filter();
    }
}
