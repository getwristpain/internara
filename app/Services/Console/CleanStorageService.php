<?php

namespace App\Services\Console;

use App\Helpers\Debugger;
use App\Services\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Service untuk membersihkan direktori penyimpanan dari file sementara dan cache.
 */
class CleanStorageService extends Service
{
    /**
     * Instance perintah konsol.
     *
     * @var Command
     */
    protected Command $command;

    /**
     * Konstruktor CleanStorageService.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        parent::__construct();
        $this->command = $command;
    }

    /**
     * Menjalankan proses pembersihan direktori penyimpanan.
     *
     * @return void
     */
    public function run(): void
    {
        $folders = [
            'app/private/cache',
            'app/private/livewire-tmp',
            'app/public/uploads',
            'debugbar',
            'framework/cache/data',
            'framework/livewire-temp',
            'framework/sessions',
            'framework/testing',
            'framework/views',
            'logs',
        ];

        try {
            foreach ($folders as $folder) {
                $directory = storage_path($folder);
                if (File::exists($directory)) {
                    $this->command->info('Membersihkan: ' . $folder);
                    if (!File::cleanDirectory($directory)) {
                        $this->command->warn('Direktori tidak dapat dibersihkan atau tidak ditemukan: ' . $folder);
                    }
                }
            }
        } catch (\Throwable $th) {
            $this->command->error('Terjadi kesalahan saat membersihkan penyimpanan.');
            Debugger::handle($th, $th->getMessage());
        }
    }
}
