<?php

namespace App\Console\Commands;

use App\Helpers\Debugger;
use Illuminate\Console\Command;
use App\Services\Console\CleanStorageService;

/**
 * Perintah konsol untuk membersihkan penyimpanan dari file sementara dan cache.
 */
class CleanStorageCommand extends Command
{
    /**
     * Nama dan signature perintah konsol.
     *
     * @var string
     */
    protected $signature = 'storage:clean';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Membersihkan penyimpanan dari file sementara dan cache.';

    /**
     * Menjalankan proses pembersihan storage.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Proses pembersihan penyimpanan dimulai.');

        try {
            app(CleanStorageService::class, ['command' => $this])->run();
        } catch (\Throwable $th) {
            $this->error('Gagal membersihkan penyimpanan.');
            Debugger::handle($th, $th->getMessage());
            return self::FAILURE;
        }

        $this->info('Penyimpanan berhasil dibersihkan.');
        return self::SUCCESS;
    }
}
