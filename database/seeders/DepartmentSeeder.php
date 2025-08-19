<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Teknik Elektro', 'description' => 'Jurusan Teknik Elektro'],
            ['name' => 'Teknik Informatika', 'description' => 'Jurusan Teknik Informatika'],
            ['name' => 'Teknik Komputer', 'description' => 'Jurusan Teknik Komputer'],
            ['name' => 'Teknik Mesin', 'description' => 'Jurusan Teknik Mesin'],
        ];

        $schoolId = School::firstOrFail()?->id;

        foreach ($departments as $dept) {
            Department::updateOrCreate(
                [
                    'name' => $dept['name'],
                ],
                [
                    'name' => $dept['name'],
                    'description' => $dept['description'],
                    'school_id' => $schoolId,
                ]
            );
        }
    }
}
