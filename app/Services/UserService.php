<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public function getOwner(): ?User
    {
        return User::role('Owner')->first();
    }

    public function create(array $data, string $type = 'student'): User
    {
        $user = $type === 'owner'
            ? $this->getOwner()
            : new User();

        try {
            $this->ensurePasswordHashed($data);
            $this->ensureUsernameFilled($data, $type);
            $this->ensureUserHasRole($data, $type);

            $user->fill($data)->save();

            $user->syncRoles($data['roles'] ?? 'student');
            $user->syncStatus($type === 'owner' ? 'protected' : 'pending-activation');

            return $user;
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal menyimpan data pengguna.',
                'Failed to save User: ' . $th->getMessage(),
            );
        }
    }

    protected function ensurePasswordHashed(array &$data): void
    {
        if (!str_starts_with($data['password'], '$2y$')) {
            $data['password'] = Hash::make($data['password']);
        }
    }

    protected function ensureUsernameFilled(array &$data, string $type = 'student'): void
    {
        if (!$data['username']) {
            $data['username'] = $this->generateUsername($type);
        }
    }

    protected function ensureUserHasRole(array &$data, string $type = 'student'): void
    {
        if (!$data['roles']) {
            $data['roles'] = $type === 'owner'
                ? ['Owner', 'Admin']
                : [ucfirst($type)];
        }

        $data['roles'] = Arr::wrap($data['roles']);
    }

    protected function generateUsername(string $type = 'student'): string
    {
        $unamePrefix = [
            'owner' => 'owner',
            'admin' => 'ad',
            'student' => 'st',
            'teacher' => 'te',
            'supervisor' => 'sv',
        ];

        return uniqid($unamePrefix[$type]);
    }
}
