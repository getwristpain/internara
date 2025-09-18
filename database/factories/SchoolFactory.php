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
        $address = fake()->address();
        $city = $this->getCityAddress($address);

        $name = 'Sekolah Kejuruan ' . $city;

        $initials = str($name)
            ->explode(' ')
            ->map(fn ($word) => str($word)->substr(0, 1)->upper())
            ->implode('');

        $domain = fake()->safeEmailDomain();
        $web = strtolower(implode('.', ['http://www', $initials, $domain]));

        return [
            'name' => $name,
            'email' => strtolower($initials.'@'.$domain),
            'telp' => fake()->regexify('0[0-9]{3}-[0-9]{4}-[0-9]{4}'),
            'fax' => fake()->regexify('0[0-9]{3}-[0-9]{4}-[0-9]{4}'),
            'address' => $address,
            'postal_code' => fake()->unique()->randomNumber(nbDigits: 6, strict: true),
            'principal_name' => fake()->name(),
            'website' => $web,
            'logo_url' => config('app.logo'),
        ];
    }

    private function getCityAddress(string $address): string
    {
        $city = str($address)
            ->explode(',')
            ->slice(-2, 1)
            ->first();

        $city = preg_replace('/\d+/', '', trim($city));
        $city = preg_replace('/\s+/', ' ', trim($city));

        return $city;
    }
}
