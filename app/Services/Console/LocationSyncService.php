<?php

namespace App\Services\Console;

use App\Models\Location;
use App\Helpers\Connection;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Services\LocationService;
use App\Services\Console\CommandService;
use App\Services\Http\WilayahHttpService;

/**
 * ------------------------------------------------------------------------
 * LocationSyncService
 * ------------------------------------------------------------------------
 * Service to sync and optionally restore Indonesian location data.
 *
 * @property-read LocationService $locationService
 * @property-read WilayahHttpService $wilayahHttpService
 */
class LocationSyncService extends CommandService
{
    /**
     * Whether to restore from backup.
     */
    protected bool $restore = false;

    /**
     * Constructor.
     */
    public function __construct(Command $command, bool $restore = false)
    {
        parent::__construct($command);

        $this->useServices([
            LocationService::class,
            WilayahHttpService::class,
        ]);

        $this->restore = $restore;
    }

    /**
     * Sync or restore all location data.
     */
    public function syncAll(): void
    {
        if ($this->restore || !Connection::checkInternetConnectivity()) {
            $this->restoreFromBackupIfExists();
            return;
        }

        $saved = $this->saveLocations();

        if (!$saved) {
            $this->restoreFromBackupIfExists();
            return;
        }

        $this->backupLocations();
    }

    /**
     * Restore from latest location backup if exists.
     */
    protected function restoreFromBackupIfExists(): bool
    {
        $this->command->newLine();
        $this->command->info('Checking for available backup...');

        $backups = glob('database/backups/locations_backup_*.csv');
        if (empty($backups)) {
            $this->command->info('No backup found. Restore skipped.');
            return false;
        }

        usort($backups, fn ($a, $b) => filemtime($b) <=> filemtime($a));
        $latest = $backups[0] ?? null;

        $this->command->info("Restoring from backup file: {$latest}");

        Location::truncate();
        $this->runShellCommand(
            'sqlite3 database/database.sqlite -cmd ".mode csv" -cmd ".import ' . escapeshellarg($latest) . ' locations"'
        );

        $this->command->info('✔ Locations restored from backup.');
        return true;
    }

    /**
     * Save location data from API to database.
     */
    protected function saveLocations(): bool
    {
        $total = [
            'provinces' => 0,
            'regencies' => 0,
            'districts' => 0,
            'villages' => 0,
        ];

        [$saved, $total] = $this->locationService->model()->transaction(function () use ($total): array {
            $provinces = $this->wilayahHttpService->getProvinces()->toArray();
            $total['provinces'] = count($provinces);

            if (!$this->upsertLevel($provinces, null, 'province')) {
                return [false, $total];
            }

            foreach ($provinces as $prov) {
                $provId = $this->findLocationId($prov['name'], 'province');
                if (!$provId) {
                    continue;
                }

                $regencies = $this->wilayahHttpService->getRegencies($prov['id'])->toArray();
                $total['regencies'] = count($regencies);

                if (!$this->upsertLevel($regencies, $provId, 'regency', $prov['name'] ?? '')) {
                    return [false, $total];
                }

                foreach ($regencies as $reg) {
                    $regId = $this->findLocationId($reg['name'], 'regency', $provId);
                    if (!$regId) {
                        continue;
                    }

                    $districts = $this->wilayahHttpService->getDistricts($reg['id'])->toArray();
                    $total['districts'] = count($districts);

                    if (!$this->upsertLevel($districts, $regId, 'district', $reg['name'] ?? '')) {
                        return [false, $total];
                    }

                    foreach ($districts as $dist) {
                        $distId = $this->findLocationId($dist['name'], 'district', $regId);
                        if (!$distId) {
                            continue;
                        }

                        $villages = $this->wilayahHttpService->getVillages($dist['id'])->toArray();
                        $total['villages'] = count($villages);

                        if (!$this->upsertLevel($villages, $distId, 'village', $dist['name'] ?? '')) {
                            return [false, $total];
                        }
                    }
                }
            }

            return [true, $total];
        });

        if (!$saved) {
            return false;
        }

        $this->command->newLine();
        $this->command->info('✅ All location data saved successfully.');
        $this->command->info("Total: {$total['provinces']} provinces, {$total['regencies']} regencies, {$total['districts']} districs, {$total['villages']} villages.");

        return true;
    }

    /**
     * Backup locations table to CSV.
     */
    protected function backupLocations(): void
    {
        $this->command->info('Backing up locations table...');

        $backupDir = 'database/backups';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $this->cleanOldBackups($backupDir);

        $backupFile = "locations_backup_" . date('Ymd_His') . ".csv";
        $this->runShellCommand(
            'sqlite3 database/database.sqlite -header -csv "SELECT * FROM locations;" > ' . $backupDir . '/' . $backupFile
        );

        $this->command->info("Backup completed: {$backupFile}");
    }

    /**
     * Upsert location level data to DB.
     */
    protected function upsertLevel(array $items, ?int $parentId, string $type, string $name = ''): bool
    {
        $pluralType = Str::plural($type);
        $recent = empty($name) ? $pluralType : "{$pluralType} of {$name}";

        if (!$this->locationService->upsert($items, $parentId, $type)) {
            $this->command->error("Failed to save data for {$type}.");
            return false;
        }

        $this->command->info("✔ {$recent} data saved successfully.");
        return true;
    }

    /**
     * Find location ID based on criteria.
     */
    protected function findLocationId(string $name, string $type, ?int $parentId = null): ?int
    {
        $criteria = [
            'name' => $name,
            'type' => $type,
        ];

        if ($parentId !== null) {
            $criteria['parent_id'] = $parentId;
        }

        $id = $this->locationService->findId($criteria);
        if (!$id) {
            $this->command->error("Location [{$type}] \"{$name}\" not found.");
        }

        return $id;
    }

    /**
     * Clean old location backup files.
     */
    protected function cleanOldBackups(string $dir): void
    {
        $backups = glob("{$dir}/locations_backup_*.csv");
        if (count($backups) <= 1) {
            return;
        }

        usort($backups, fn ($a, $b) => filemtime($b) <=> filemtime($a));
        foreach (array_slice($backups, 1) as $old) {
            @unlink($old);
        }
    }
}
