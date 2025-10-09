<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Program;
use App\Models\School;
use App\Models\User;
use App\Services\Service;
use App\Exceptions\AppException;

class SetupService extends Service
{
    public function ensureIsNotInstalled(): bool
    {
        try {
            return !setting('is_installed', true);
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal melanjutkan instalasi',
                'Installation failed: ' . $th->getMessage(),
                previous: $th
            );
        }
    }

    public function ensureOwnerExists(): bool
    {
        try {
            return User::role('Owner')->exists();
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal melanjutkan konfigurasi akun.',
                'Failed to setup Owner: ' . $th->getMessage(),
                previous: $th
            );
        }
    }

    public function ensureSchoolExists(): bool
    {
        try {
            return School::exists();
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal melanjutkan konfigurasi sekolah.',
                'Failed to setup School: ' . $th->getMessage(),
                previous: $th
            );
        }
    }

    public function ensureDepartmentExists(): bool
    {
        try {
            return Department::exists();
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal melanjutkan konfigurasi jurusan.',
                'Failed to setup Department: ' . $th->getMessage(),
                previous: $th
            );
        }
    }

    public function ensureProgramExists(): bool
    {
        try {
            return Program::exists();
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal melanjutkan konfigurasi program PKL: ' . $th->getMessage(),
                'Failed to setup Program: ' . $th->getMessage(),
                previous: $th
            );
        }
    }

    public function performSetup(): bool
    {
        if (setting()->set('is_installed', true)) {
            session()->flush();

            return true;
        }

        return false;
    }
}
