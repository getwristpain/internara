<?php

namespace App\Services\Console;

use App\Services\LocationService;
use App\Services\Http\WilayahHttpService;
use App\Services\Service;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LocationSyncService extends Service
{
    protected ?Command $command = null;
    protected LocationService $locationService;

    public function __construct(?Command $command = null, ?LocationService $locationService = null)
    {
        parent::__construct();

        $this->command = $command;
        $this->locationService = $locationService ?? app(LocationService::class);
    }

    public function syncAll(): void
    {
        if ($this->restoreFromBackupIfExists()) {
            return;
        }

        $this->command->newLine();
        $this->storeLocations();

        $this->command->newLine();
        $this->backupLocations();
    }

    protected function restoreFromBackupIfExists(): bool
    {
        $this->command->info('Checking for existing backup...');
        $this->command->newLine();

        $backupFiles = glob('database/backups/locations_backup_*.csv');
        if (empty($backupFiles)) {
            $this->command->info('No backup found, skipping restore.');
            return false;
        }

        usort($backupFiles, function ($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });

        $latestBackup = $backupFiles[0] ?? null;
        $this->command->info("Restoring from backup: {$latestBackup}");

        \DB::table('locations')->truncate();
        $this->runShellCommand('sqlite3 database/database.sqlite -cmd ".mode csv" -cmd ".import ' . escapeshellarg($latestBackup) . ' locations"');

        $this->command->newLine();
        $this->command->info('✔ Locations restored from backup successfully.');
        return true;
    }

    protected function storeLocations(): void
    {
        $wilayah = app(WilayahHttpService::class);

        $this->locationService->transaction(function () use ($wilayah) {
            $provinces = $wilayah->getProvinces();
            if (!$this->locationService->insert($provinces->toArray(), null, 'province')) {
                $this->command->error('Failed to insert provinces.');
                return;
            }

            $this->command->info('✔ Provinces stored successfully.');

            foreach ($provinces as $province) {
                $provinceId = $this->locationService->findId([
                    'name' => $province['name'],
                    'type' => 'province',
                ]);

                if (!$provinceId) {
                    $this->command->error("Province {$province['name']} not found.");
                    continue;
                }

                $regencies = $wilayah->getRegencies($province['id']);

                if (!$this->locationService->insert($regencies->toArray(), $provinceId, 'regency')) {
                    $this->command->error("Failed to insert regencies for province: {$province['name']}");
                    return;
                }

                $this->command->info("✔ Stored regencies for province: {$province['name']}");

                foreach ($regencies as $regency) {
                    $regencyId = $this->locationService->findId([
                        'parent_id' => $provinceId,
                        'name' => $regency['name'],
                        'type' => 'regency',
                    ]);

                    if (!$regencyId) {
                        $this->command->error("Regency {$regency['name']} not found for province {$province['name']}");
                        continue;
                    }

                    $districts = $wilayah->getDistricts($regency['id']);

                    if (!$this->locationService->insert($districts->toArray(), $regencyId, 'district')) {
                        $this->command->error("Failed to insert districts for regency: {$regency['name']}");
                        return;
                    }

                    $this->command->info("✔ Stored districts for regency: {$regency['name']}");

                    foreach ($districts as $district) {
                        $districtId = $this->locationService->findId([
                            'parent_id' => $regencyId,
                            'name' => $district['name'],
                            'type' => 'district',
                        ]);

                        if (!$districtId) {
                            $this->command->error("District {$district['name']} not found for regency {$regency['name']}");
                            continue;
                        }

                        $villages = $wilayah->getVillages($district['id']);

                        if (!$this->locationService->insert($villages->toArray(), $districtId, 'village')) {
                            $this->command->error("Failed to insert villages for district: {$district['name']}");
                            return;
                        }

                        $this->command->info("✔ Stored villages for district: {$district['name']}");
                    }
                }
            }
        });

        $this->command->newLine();
        $this->command->info('✅ All locations stored successfully.');
    }

    protected function backupLocations(): void
    {
        $this->command->info('Backing up locations table...');

        if (!is_dir('database/backups')) {
            mkdir('database/backups', 0755, true);
        }

        $backupFiles = glob('database/backups/locations_backup_*.csv');
        if (count($backupFiles) > 1) {
            usort($backupFiles, function ($a, $b) {
                return filemtime($b) <=> filemtime($a);
            });

            foreach (array_slice($backupFiles, 1) as $oldFile) {
                @unlink($oldFile);
            }
        }

        $backupFile = 'locations_backup_' . date('Ymd_His') . '.csv';
        $this->runShellCommand('sqlite3 database/database.sqlite -header -csv "SELECT * FROM locations;" > database/backups/' . $backupFile);

        $this->command->info("Backup created: {$backupFile}");
    }

    private function runShellCommand(string $command)
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
