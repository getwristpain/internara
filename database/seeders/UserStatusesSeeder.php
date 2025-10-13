<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'user-pending-activation',
                'type' => 'user',
                'label' => 'aktivasi tertunda',
                'color' => 'yellow',
                'icon' => '',
                'description' => '',
            ],
            [
                'name' => 'user-active',
                'type' => 'user',
                'label' => 'aktif',
                'color' => 'green',
                'icon' => '',
                'description' => '',
            ],
            [
                'name' => 'user-verified',
                'type' => 'user',
                'label' => 'terverifikasi',
                'color' => 'blue',
                'icon' => '',
                'description' => '',
            ],
            [
                'name' => 'user-protected',
                'type' => 'user',
                'label' => 'terlindungi',
                'color' => 'neutral',
                'icon' => '',
                'description' => '',
            ],
            [
                'name' => 'user-banned',
                'type' => 'user',
                'label' => 'terlarang',
                'color' => 'red',
                'icon' => '',
                'description' => '',
            ],
            [
                'name' => 'user-blocked',
                'type' => 'user',
                'label' => 'terblokir',
                'color' => 'black',
                'icon' => '',
                'description' => '',
            ],
            [
                'name' => 'user-archieved',
                'type' => 'user',
                'label' => 'diarsipkan',
                'color' => 'gray',
                'icon' => '',
                'description' => '',
            ]
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(['name' => $status['name']], $status);
        }
    }
}
