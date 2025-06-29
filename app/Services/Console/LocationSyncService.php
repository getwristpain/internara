<?php

namespace App\Services\Console;

use App\Helpers\Connection;
use App\Services\Http\WilayahHttpService;
use App\Services\LocationService;
use App\Services\Service;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * Service untuk sinkronisasi dan backup data lokasi wilayah Indonesia.
 */
class LocationSyncService extends Service
{
    /**
     * Instance perintah konsol.
     *
     * @var Command|null
     */
    protected ?Command $command = null;

    /**
     * Status restore dari backup.
     *
     * @var bool
     */
    protected bool $restore = false;

    /**
     * Konstruktor LocationSyncService.
     *
     * @param Command|null $command
     * @param bool $restore
     */
    public function __construct(?Command $command = null, bool $restore = false)
    {
        parent::__construct();

        $this->command = $command;
        $this->restore = $restore;

        $this->useServices([
            LocationService::class,
            WilayahHttpService::class
        ]);
    }

    /**
     * Sinkronisasi seluruh data lokasi atau restore dari backup jika diperlukan.
     *
     * @return void
     */
    public function syncAll(): void
    {
        if ($this->restore || !Connection::checkInternetConnectivity()) {
            $this->restoreFromBackupIfExists();
            return;
        }

        $this->command?->newLine();
        $this->saveLocations();

        $this->command?->newLine();
        $this->backupLocations();
    }

    /**
     * Restore data lokasi dari backup jika tersedia.
     *
     * @return bool
     */
    protected function restoreFromBackupIfExists(): bool
    {
        $this->command?->info('Memeriksa backup yang tersedia...');

        $backupFiles = glob('database/backups/locations_backup_*.csv');
        if (empty($backupFiles)) {
            $this->command?->info('Backup tidak ditemukan, proses restore dilewati.');
            return false;
        }

        usort($backupFiles, fn ($a, $b) => filemtime($b) <=> filemtime($a));
        $latestBackup = $backupFiles[0] ?? null;
        $this->command?->info("Melakukan restore dari backup: {$latestBackup}");

        \DB::table('locations')->truncate();
        $this->runShellCommand('sqlite3 database/database.sqlite -cmd ".mode csv" -cmd ".import ' . escapeshellarg($latestBackup) . ' locations"');

        $this->command?->info('✔ Data lokasi berhasil direstore dari backup.');
        return true;
    }

    /**
     * Simpan seluruh data lokasi dari API ke database.
     *
     * @return void
     */
    protected function saveLocations(): void
    {
        $wilayah = $this->useServices(WilayahHttpService::class);

        $this->locationService->transaction(function () use ($wilayah) {
            $provinces = $wilayah->getProvinces();
            if (!$this->locationService->insert($provinces->toArray(), null, 'province')) {
                $this->command?->error('Gagal menyimpan data provinsi.');
                return;
            }
            $this->command?->info('✔ Data provinsi berhasil disimpan.');

            foreach ($provinces as $province) {
                $provinceId = $this->locationService->findId([
                    'name' => $province['name'],
                    'type' => 'province',
                ]);
                if (!$provinceId) {
                    $this->command?->error("Provinsi {$province['name']} tidak ditemukan.");
                    continue;
                }

                $regencies = $wilayah->getRegencies($province['id']);
                if (!$this->locationService->insert($regencies->toArray(), $provinceId, 'regency')) {
                    $this->command?->error("Gagal menyimpan data kabupaten/kota untuk provinsi: {$province['name']}");
                    return;
                }
                $this->command?->info("✔ Data kabupaten/kota berhasil disimpan untuk provinsi: {$province['name']}");

                foreach ($regencies as $regency) {
                    $regencyId = $this->locationService->findId([
                        'parent_id' => $provinceId,
                        'name' => $regency['name'],
                        'type' => 'regency',
                    ]);
                    if (!$regencyId) {
                        $this->command?->error("Kabupaten/Kota {$regency['name']} tidak ditemukan untuk provinsi {$province['name']}");
                        continue;
                    }

                    $districts = $wilayah->getDistricts($regency['id']);
                    if (!$this->locationService->insert($districts->toArray(), $regencyId, 'district')) {
                        $this->command?->error("Gagal menyimpan data kecamatan untuk kabupaten/kota: {$regency['name']}");
                        return;
                    }
                    $this->command?->info("✔ Data kecamatan berhasil disimpan untuk kabupaten/kota: {$regency['name']}");

                    foreach ($districts as $district) {
                        $districtId = $this->locationService->findId([
                            'parent_id' => $regencyId,
                            'name' => $district['name'],
                            'type' => 'district',
                        ]);
                        if (!$districtId) {
                            $this->command?->error("Kecamatan {$district['name']} tidak ditemukan untuk kabupaten/kota {$regency['name']}");
                            continue;
                        }

                        $villages = $wilayah->getVillages($district['id']);
                        if (!$this->locationService->insert($villages->toArray(), $districtId, 'village')) {
                            $this->command?->error("Gagal menyimpan data desa/kelurahan untuk kecamatan: {$district['name']}");
                            return;
                        }
                        $this->command?->info("✔ Data desa/kelurahan berhasil disimpan untuk kecamatan: {$district['name']}");
                    }
                }
            }
        });

        $this->command?->newLine();
        $this->command?->info('✅ Seluruh data lokasi berhasil disimpan.');
    }

    /**
     * Backup tabel locations ke file CSV.
     *
     * @return void
     */
    protected function backupLocations(): void
    {
        $this->command?->info('Membackup tabel locations...');

        if (!is_dir('database/backups')) {
            mkdir('database/backups', 0755, true);
        }

        $backupFiles = glob('database/backups/locations_backup_*.csv');
        if (count($backupFiles) > 1) {
            usort($backupFiles, fn ($a, $b) => filemtime($b) <=> filemtime($a));
            foreach (array_slice($backupFiles, 1) as $oldFile) {
                @unlink($oldFile);
            }
        }

        $backupFile = 'locations_backup_' . date('Ymd_His') . '.csv';
        $this->runShellCommand('sqlite3 database/database.sqlite -header -csv "SELECT * FROM locations;" > database/backups/' . $backupFile);

        $this->command?->info("Backup berhasil dibuat: {$backupFile}");
    }

    /**
     * Jalankan perintah shell.
     *
     * @param string $command
     * @return void
     */
    private function runShellCommand(string $command): void
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
