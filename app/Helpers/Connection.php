<?php

namespace App\Helpers;

use App\Helpers\Helper;
use Symfony\Component\Process\Process;

class Connection extends Helper
{
    public static function checkInternetConnectivity(): bool
    {
        try {
            $process = Process::fromShellCommandline('ping -c 1 -W 2 google.com');
            $process->run();

            if ($process->isSuccessful()) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            Debugger::debug($th, 'Error occurred while checking internet connection.');
            return false;
        }
    }
}
