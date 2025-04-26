<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    protected array $data = [
        [
            'name' => 'Teknik Komputer dan Jaringan',
            'code' => 'TKJ',
            'classrooms' => [
                [
                    'level' => 'XII',
                    'name' => 'A',
                    'code' => 'XII-TKJ-A',
                ],
                [
                    'level' => 'XII',
                    'name' => 'B',
                    'code' => 'XII-TKJ-B',
                ],
            ],
        ],
        [
            'name' => 'Teknik Konstruksi Gedung Sanitasi dan Perawatan',
            'code' => 'TKGSP',
            'classrooms' => [
                [
                    'level' => 'XII',
                    'name' => 'A',
                    'code' => 'XII-TKGSP-A',
                ],
                [
                    'level' => 'XII',
                    'name' => 'B',
                    'code' => 'XII-TKGSP-B',
                ],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::first() ?? School::create([
            'name' => 'Internara',
            'address' => [],
            'email' => 'school@example.com',
            'phone' => '1234567890',
            'fax' => '1234567890',
            'principal_name' => 'Kepala Sekolah',
            'website' => 'http://example.com',
        ]);

        collect($this->data)->each(function ($department) use ($school) {
            $departmentModel = $school->departments()->create([
                'code' => $department['code'],
                'name' => $department['name'],
                'school_id' => $school->id,
            ]);

            collect($department['classrooms'])->each(function ($classroom) use ($departmentModel) {
                $departmentModel->classrooms()->create($classroom);
            });
        });
    }
}
