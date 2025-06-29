<?php

namespace App\Helpers;

use Symfony\Component\Process\Process;

/**
 * Helper for checking internet connectivity.
 */
class Connection extends Helper
{
    /**
     * Check if internet connection is available.
     *
     * @param int $timeout
     * @return bool
     */
    public static function checkInternetConnectivity(int $timeout = 3): bool
    {
        try {
            $process = Process::fromShellCommandline("ping -c 1 -W {$timeout} google.com");
            $process->run();

            return $process->isSuccessful();
        } catch (\Throwable $exception) {
            Debugger::handle($exception, 'Terjadi error saat memeriksa koneksi internet.');
            return false;
        }
    }
}
