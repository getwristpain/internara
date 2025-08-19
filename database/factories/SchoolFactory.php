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
        $name = 'Sekolah Kejuruan ' . $this->faker->city;
        $slug = Transform::from($name)->initials()->slug('')->toString();

        $domain = $this->faker->safeEmailDomain();
        $web = implode('.', ['http://www', $slug, $domain]);

        return [
            'name' => $name,
            'email' => $slug.'@'.$domain,
            'telp' => $this->faker->regexify('0[0-9]{3}-[0-9]{4}-[0-9]{4}'),
            'fax' => $this->faker->regexify('0[0-9]{3}-[0-9]{4}-[0-9]{4}'),
            'address' => $this->faker->address(),
            'principal_name' => $this->faker->name(),
            'website' => $web,
            'logo_path' => config('app.logo'),
        ];
    }
}
