<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Department;
use App\Models\Program;
use App\Models\School;
use App\Models\User;
use App\Services\Service;

class SetupService extends Service
{
    public function setupWelcome(): bool
    {
        $this->ensureNotRateLimited('setup:welcome', maxAttempts: 10);
        return !setting('is_installed', true);
    }

    public function setupAccount(): bool
    {
        $this->ensureNotRateLimited('setup:account', maxAttempts: 10);
        return User::role('Owner')->exists();
    }

    public function setupSchool(): bool
    {
        $this->ensureNotRateLimited('setup:school', maxAttempts: 10);
        return School::exists();
    }

    public function setupDepartment(): bool
    {
        $this->ensureNotRateLimited('setup:department', maxAttempts: 10);
        return Department::exists();
    }

    public function setupProgram(): bool
    {
        $this->ensureNotRateLimited('setup:program', maxAttempts: 10);
        return Program::exists();
    }

    public function setupComplete(): bool
    {
        $this->ensureNotRateLimited('setup:complete', maxAttempts: 10);

        try {
            $school = School::first();

            setting()->set('brand_name', $school?->name);
            setting()->set('brand_logo', $school?->getRawOriginal('logo_url'));
            setting()->set('is_installed', true);

            return setting('is_installed', false);
        } catch (\Throwable $th) {
            throw new AppException(
                'Terjadi kesalahan saat menyelesaikan instalasi.',
                'Failed to install app: ' . $th->getMessage(),
                previous: $th
            );
        }
    }
}
