<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedingRoles([
            'Owner',
            'Admin',
            'Student',
            'Teacher',
            'Supervisor',
        ]);
    }

    public function seedingRoles(array $roles): void
    {
        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => Str::title($role)]);
        }
    }
}
