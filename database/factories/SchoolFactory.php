<?php

namespace Database\Factories;

use App\Helpers\Transform;
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
        $city = str($address)
            ->explode(',')
            ->slice(-2, 1)
            ->first();

        $city = preg_replace('/\d+/', '', trim($city));
        $city = preg_replace('/\s+/', ' ', trim($city));

        $name = 'Sekolah Kejuruan '.$city;
        $slug = Transform::from($name)->initials()->slug('')->toString();

        $domain = fake()->safeEmailDomain();
        $web = implode('.', ['http://www', $slug, $domain]);

        return [
            'name' => $name,
            'email' => $slug.'@'.$domain,
            'telp' => fake()->regexify('0[0-9]{3}-[0-9]{4}-[0-9]{4}'),
            'fax' => fake()->regexify('0[0-9]{3}-[0-9]{4}-[0-9]{4}'),
            'address' => $address,
            'principal_name' => fake()->name(),
            'website' => $web,
            'logo_path' => config('app.logo'),
        ];
    }
}
