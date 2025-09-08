<?php

namespace Database\Seeders;

use App\Helpers\Generator;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Administrator',
            'email' => 'superadmin@example.com',
            'username' => Generator::username('ad', 8),
            'password' => Hash::make('password'),
        ];

        User::updateOrCreate(
            ['email' => $user['email']],
            $user
        )->assignRole(['admin', 'owner'])
        ->syncStatuses('protected');
    }
}
