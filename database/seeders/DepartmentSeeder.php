<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    protected array $data = [
        [
            'name' => 'Teknik Komputer dan Jaringan',
            'code' => 'TKJ',
            'classrooms' => [
                [
                    'name' => 'XII TKJ A',
                    'code' => 'XII-TKJ-A',
                ],
                [
                    'name' => 'XII TKJ B',
                    'code' => 'XII-TKJ-B',
                ]
            ],
        ],
        [
            'name' => 'Teknik Konstruksi Gedung Sanitasi dan Perawatan',
            'code' => 'TKGSP',
            'classrooms' => [
                [
                    'name' => 'XII TKGSP A',
                    'code' => 'XII-TKGSP-A',
                ],
                [
                    'name' => 'XII TKGSP B',
                    'code' => 'XII-TKGSP-B',
                ]
            ],
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->data)->each(function ($department) {
            $departmentModel = Department::create([
                'name' => $department['name'],
                'code' => $department['code'],
            ]);

            collect($department['classrooms'])->each(function ($classroom) use ($departmentModel) {
                $departmentModel->classrooms()->create($classroom);
            });
        });
    }
}
