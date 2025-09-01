<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'user' => [
                [
                    'name' => 'protected',
                    'color' => 'success'
                ],
                [
                    'name' => 'verified',
                    'color' => 'success'
                ],
                [
                    'name' => 'active',
                    'color' => 'info'
                ],
                [
                    'name' => 'inactive',
                    'color' => 'muted',
                ],
                [
                    'name' => 'banned',
                    'color' => 'danger'
                ],
                [
                    'name' => 'pending-activation',
                    'color' => 'warning',
                ],
                [
                    'name' => 'archieved',
                    'color' => 'secondary'
                ],
            ]
        ];

        $this->storeStatuses($statuses);
    }

    protected function storeStatuses(array $statuses): void
    {
        $statuses = $this->normalizeStatuses($statuses);
        foreach ($statuses as $status) {
            Status::updateOrCreate(['name' => $status['name']], $status);
        }
    }

    protected function normalizeStatuses(array $statuses): array
    {
        return collect($statuses)
            ->mapWithKeys(fn ($status, $key) => array_map(fn ($s) => $s + ['type' => $key], $status))
            ->all();
    }
}
