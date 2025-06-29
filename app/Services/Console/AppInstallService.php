<?php

namespace App\Services\Console;

use App\Services\Service;
use App\Helpers\Debugger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

/**
 * Service untuk menangani proses instalasi dan setup aplikasi secara otomatis.
 */
class AppInstallService extends Service
{
    /**
     * Menyimpan instance perintah konsol.
     *
     * @var Command
     */
    protected Command $command;

    /**
     * Konstruktor untuk AppInstallService.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        parent::__construct();
        $this->command = $command;
    }

    /**
     * Menjalankan seluruh proses instalasi aplikasi secara otomatis.
     *
     * @return void
     */
    public function install(): void
    {
        $this->command->newLine();
        $this->clearCache();

        $this->command->newLine();
        $this->cleanLog();

        $this->command->newLine();
        $this->checkEnvFile();

        $this->command->newLine();
        $this->generateAppKey();

        $this->command->newLine();
        $this->setupBasicEnv();

        $this->command->newLine();
        $this->setupDatabase();

        $this->command->newLine();
        $this->runMigration();

        $this->command->newLine();
        $this->runMigrationFresh();

        $this->command->newLine();
        $this->seedDatabase();

        $this->command->newLine();
        $this->createStorageLink();

        $this->command->newLine();
        $this->cleanStorage();

        $this->command->newLine();
        $this->syncDataset();

        $this->command->newLine();
        $this->buildFrontendAssets();

        $this->command->newLine();
        $this->optimizeApplication();
    }

    /**
     * Membersihkan cache aplikasi.
     */
    protected function clearCache(): void
    {
        $this->runArtisan('optimize:clear', [], 'Membersihkan cache aplikasi...');
    }

    /**
     * Menghapus log aplikasi.
     */
    protected function cleanLog(): void
    {
        $this->runArtisan('activitylog:clean', [], 'Menghapus log aplikasi...');
    }

    /**
     * Memastikan file .env tersedia.
     */
    protected function checkEnvFile(): void
    {
        $this->command->info('Memvalidasi file environment...');
        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');
        if (!File::exists($envPath)) {
            $this->command->info('File environment tidak ditemukan. Membuat dari contoh...');
            if (File::exists($envExamplePath)) {
                File::copy($envExamplePath, $envPath);
                $this->command->info('File environment berhasil dibuat dari .env.example.');
            } else {
                $this->fail('File .env.example tidak ditemukan. Silakan sediakan file contoh tersebut.');
            }
        } else {
            $this->command->info('File environment sudah tersedia. Lewati pembuatan.');
        }
    }

    /**
     * Membuat application key.
     */
    protected function generateAppKey(): void
    {
        $this->runArtisan('key:generate', [], 'Membuat application key...', 'Application key berhasil dibuat.');
    }

    /**
     * Mengatur variabel environment dasar.
     */
    protected function setupBasicEnv(): void
    {
        try {
            $this->command->info('Mengatur variabel environment...');
            $envConfig = [
                'APP_NAME' => config('app.name', 'Internara'),
                'APP_TIMEZONE' => config('app.timezone', 'Asia/Jakarta'),
                'APP_LOCALE' => config('app.locale', 'id'),
                'APP_FALLBACK_LOCALE' => config('app.fallback_locale', 'id'),
                'APP_FAKER_LOCALE' => config('app.faker_locale', 'id_ID'),
            ];
            foreach ($envConfig as $key => $value) {
                $this->updateEnv($key, $value);
            }
            $this->command->info('Variabel environment berhasil dikonfigurasi.');
        } catch (\Throwable $th) {
            $this->fail('Gagal mengatur variabel environment.', $th);
        }
    }

    /**
     * Mengatur koneksi database.
     */
    protected function setupDatabase(): void
    {
        $this->command->info('Mengatur koneksi database...');
        if (!confirm('Apakah Anda ingin mengatur koneksi database sekarang?')) {
            $this->command->info('Konfigurasi database dilewati.');
            return;
        }
        $dbTypes = ['sqlite', 'mysql', 'pgsql', 'sqlsrv'];
        $dbType = select('Pilih tipe koneksi database:', $dbTypes, 0);
        $dbConfig = [];
        if ($dbType === 'sqlite') {
            $dbConfig['DB_CONNECTION'] = 'sqlite';
            $this->command->info('Database SQLite akan digunakan di: ' . database_path('database.sqlite'));
        } else {
            $dbConfig = [
                'DB_CONNECTION' => $dbType,
                'DB_HOST' => text('Host database', '127.0.0.1'),
                'DB_PORT' => text('Port database', $dbType === 'pgsql' ? '5432' : '3306'),
                'DB_DATABASE' => text('Nama database', 'laravel'),
                'DB_USERNAME' => text('Username database', 'root'),
                'DB_PASSWORD' => password('Password database'),
            ];
        }
        foreach ($dbConfig as $key => $value) {
            $this->updateEnv($key, $value);
        }
        $this->command->info('Koneksi database berhasil dikonfigurasi.');
    }

    /**
     * Menjalankan migrasi database.
     */
    protected function runMigration(): void
    {
        $this->runArtisan('migrate', ['--force' => true], 'Menjalankan migrasi database...', 'Migrasi database selesai.', 'Migrasi database gagal.');
    }

    /**
     * Menjalankan migrasi fresh database.
     */
    protected function runMigrationFresh(): void
    {
        $this->runArtisan('migrate:fresh', ['--force' => true]);
    }

    /**
     * Menanam data awal ke database.
     */
    protected function seedDatabase(): void
    {
        $this->runArtisan('db:seed', [], 'Menanam data awal ke database...', 'Seed database selesai.', 'Seed database gagal.');
    }

    /**
     * Membuat symbolic link storage.
     */
    protected function createStorageLink(): void
    {
        $this->command->info('Membuat symbolic link storage...');
        if (File::exists(public_path('storage'))) {
            $this->command->info('Symbolic link storage sudah ada. Lewati.');
            return;
        }
        $this->runArtisan('storage:link', [], 'Membuat symbolic link storage...', 'Symbolic link storage berhasil dibuat.', 'Gagal membuat symbolic link storage.');
    }

    /**
     * Membersihkan direktori storage.
     */
    protected function cleanStorage(): void
    {
        $this->runArtisan('storage:clean', [], abort: false);
    }

    /**
     * Sinkronisasi dataset lokasi.
     */
    protected function syncDataset(): void
    {
        $this->runArtisan('location:sync', ['--restore' => true]);
    }

    /**
     * Membangun aset frontend.
     */
    protected function buildFrontendAssets(): void
    {
        $this->command->info('Membangun aset frontend...');
        try {
            $this->runShellCommand('npm install');
            $this->runShellCommand('npm run build');
            $this->command->info('Aset frontend berhasil dibangun.');
        } catch (\Throwable $th) {
            $this->skipWithWarn('Gagal membangun aset frontend.', $th);
        }
    }

    /**
     * Optimasi aplikasi.
     */
    protected function optimizeApplication(): void
    {
        $this->runArtisan('optimize', [], 'Mengoptimasi aplikasi...', 'Aplikasi berhasil dioptimasi.', 'Optimasi aplikasi gagal.', false);
    }

    /**
     * Menjalankan perintah Artisan dengan pesan opsional.
     *
     * @param string $command
     * @param array $arguments
     * @param string $startMessage
     * @param string $successMessage
     * @param string $errorMessage
     * @param bool $abort
     * @return void
     */
    protected function runArtisan(
        string $command,
        array $arguments = [],
        string $startMessage = '',
        string $successMessage = '',
        string $errorMessage = '',
        bool $abort = true
    ): void {
        if ($startMessage) {
            $this->command->info($startMessage);
        }
        try {
            $this->command->call($command, $arguments);
            if ($successMessage) {
                $this->command->info($successMessage);
            }
        } catch (\Throwable $th) {
            if (!$abort) {
                $this->skipWithWarn($errorMessage ?: "Peringatan saat menjalankan perintah: $command", $th);
                return;
            }
            $this->fail($errorMessage ?: "Terjadi kesalahan saat menjalankan perintah: $command", $th);
        }
    }

    /**
     * Menjalankan perintah shell.
     *
     * @param string $command
     * @return void
     */
    protected function runShellCommand(string $command): void
    {
        $this->command->newLine();
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
        $output = trim($process->getOutput());
        if ($output) {
            $this->command->info($output);
        }
    }

    /**
     * Update atau tambahkan nilai pada file .env.
     *
     * @param string $key
     * @param string|int|bool $value
     * @param bool $rewrite
     * @return void
     */
    protected function updateEnv(string $key, string|int|bool $value, bool $rewrite = true): void
    {
        $key = Str::upper(Str::slug($key, '_'));
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            $this->checkEnvFile();
        }
        if (!$rewrite && !empty(env($key))) {
            return;
        }
        $envContent = File::get($envPath);
        $envPattern = "/^{$key}=.*/m";
        if (preg_match($envPattern, $envContent)) {
            $envContent = preg_replace($envPattern, "{$key}={$value}", $envContent);
        } else {
            $envContent .= "\n{$key}={$value}";
        }
        File::put($envPath, $envContent);
    }

    /**
     * Batalkan proses instalasi dengan pesan error.
     *
     * @param string $message
     * @param \Throwable|null $exception
     * @return void
     */
    protected function fail(string $message, ?\Throwable $exception = null): void
    {
        if (!$exception) {
            $exception = new \Exception($message);
        }
        $this->command->error($message);
        Debugger::handle($exception, $message);
        exit(1);
    }

    /**
     * Lewati langkah dengan pesan peringatan.
     *
     * @param string $message
     * @param \Throwable|null $exception
     * @return void
     */
    protected function skipWithWarn(string $message, ?\Throwable $exception = null): void
    {
        $this->command->warn($message);
        Debugger::handle($exception, $message);
    }
}
