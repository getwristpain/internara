<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use App\Services\Console\LocationSyncService;
use Illuminate\Console\Command;

/**
 * Perintah konsol untuk mengambil dan sinkronisasi data wilayah administratif Indonesia ke tabel locations.
 */
class LocationSyncCommand extends Command
{
    /**
     * Nama dan signature perintah konsol.
     *
     * @var string
     */
    protected $signature = 'location:sync {--restore : Mengembalikan backup lokasi sebelum sinkronisasi}';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Mengambil dan sinkronisasi data wilayah administratif Indonesia ke tabel locations';

    /**
     * Menjalankan perintah sinkronisasi wilayah.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi wilayah...');
        $startTime = microtime(true);
        $restore = $this->option('restore');

        try {
            app(LocationSyncService::class, ['command' => $this, 'restore' => $restore])
                ->syncAll();
        } catch (\Throwable $e) {
            $this->error('Sinkronisasi gagal: ' . $e->getMessage());
            Debugger::handle($e, 'Terjadi error pada LocationSync: ' . $e->getMessage());
            return self::FAILURE;
        }

        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);

        $this->info("[Durasi: {$duration}s] Sinkronisasi wilayah berhasil diselesaikan.");
        return self::SUCCESS;
    }
}
