<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use App\Services\Console\AppInstallService;

/**
 * Perintah untuk mengotomatisasi instalasi dan setup aplikasi.
 */
class AppInstallCommand extends Command
{
    /**
     * Nama dan signature dari perintah konsol.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Mengotomatisasi proses instalasi dan setup, termasuk konfigurasi environment, migrasi database, dan optimasi.';

    /**
     * Menjalankan proses instalasi aplikasi secara otomatis.
     *
     * @return int
     */
    public function handle(): int
    {
        $appUrl = config('app.url', 'http://localhost:8000');
        $startTime = microtime(true);

        $this->info('Proses instalasi aplikasi telah dimulai.');
        $this->newLine();

        try {
            app(AppInstallService::class, ['command' => $this])->install();
        } catch (\Throwable $th) {
            $message = 'Terjadi kesalahan kritis selama proses instalasi. Silakan cek log untuk detail lebih lanjut.';

            $this->newLine();
            $this->error($message);
            Debugger::handle($th, $message);

            return self::FAILURE;
        }

        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);

        $this->newLine();
        $this->info("[Durasi: {$duration}s] Instalasi berhasil diselesaikan.");

        $this->newLine();
        $this->info('Untuk memulai server, jalankan: php artisan serve');
        $this->info("Anda sekarang dapat mengakses aplikasi di: {$appUrl}");

        return self::SUCCESS;
    }
}
