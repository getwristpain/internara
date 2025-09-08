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
                    'name' => 'pending-activation',
                    'color' => 'yellow',
                    'icon' => 'ri-time-line',
                ],
                [
                    'name' => 'protected',
                    'color' => 'primary',
                    'icon' => 'gmdi-admin-panel-settings-o',
                ],
                [
                    'name' => 'verified',
                    'color' => 'blue',
                    'icon' => 'ri-verified-badge-line',
                ],
                [
                    'name' => 'active',
                    'color' => 'green',
                    'icon' => 'heroicon-o-check-circle',
                ],
                [
                    'name' => 'inactive',
                    'color' => 'muted',
                    'icon' => 'heroicon-o-x-circle',
                ],
                [
                    'name' => 'banned',
                    'color' => 'red',
                    'icon' => 'fas-ban',
                ],
                [
                    'name' => 'archived',
                    'color' => 'secondary',
                    'icon' => 'heroicon-o-archive-box',
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
