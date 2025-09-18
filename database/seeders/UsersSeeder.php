<?php

namespace Database\Seeders;

use App\Helpers\Generator;
use App\Helpers\Filter;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Example',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'username' => Generator::username('ad', 8),
                'password' => Hash::make('password'),
                'roles' => ['admin'],
                'status' => 'protected'
            ],
            [
                'name' => 'Student Example',
                'email' => 'student@example.com',
                'email_verified_at' => now(),
                'username' => Generator::username('st', 8),
                'password' => Hash::make('password'),
                'roles' => ['student'],
                'status' => 'pending-activation'
            ],
            [
                'name' => 'Teacher Example',
                'email' => 'teacher@example.com',
                'email_verified_at' => now(),
                'username' => Generator::username('te', 8),
                'password' => Hash::make('password'),
                'roles' => ['teacher'],
                'status' => 'pending-activation'
            ],
            [
                'name' => 'Supervisor Example',
                'email' => 'supervisor@example.com',
                'email_verified_at' => now(),
                'username' => Generator::username('sv', 8),
                'password' => Hash::make('password'),
                'roles' => ['supervisor'],
                'status' => 'pending-activation'
            ]
        ];

        foreach ($users as $user) {
            $createdUser = User::updateOrCreate(
                ['email' => $user['email']],
                Filter::only($user, app(User::class)->getFillable())
            );

            $createdUser->assignRole($user['roles'] ?? 'guest');
            $createdUser->syncStatuses($user['status'] ?? 'pending-activation');
        }

    }
}
