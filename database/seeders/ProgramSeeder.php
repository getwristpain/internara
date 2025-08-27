<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Program;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\SchoolSeeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        if (!School::first()) {
            $this->call([
                SchoolSeeder::class
            ]);
        }

        $schoolId = School::first()?->id;

        $year = Carbon::now()->addYear()->format('Y');

        $start = Carbon::now()
            ->addYear()
            ->addMonth()
            ->startOfMonth();

        if (!$start->isMonday()) {
            $start->next('MONDAY');
        }

        $end = $start->copy()
            ->addMonths(3)
            ->endOfMonth();

        Program::create([
            'school_id' => $schoolId,
            'title' => ('Program PKL ' . $year),
            'year' => $year,
            'semester' => $faker->randomElement(['ganjil', 'genap']),
            'date_start' => $start->toDateString(),
            'date_end' => $end->toDateString(),
            'slug' => '',
        ]);
    }
}
