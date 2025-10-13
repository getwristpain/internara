<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    protected User $model;

    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }

    public function getOwner(): ?User
    {
        return $this->model::role('Owner')->first();
    }

    public function save(array $data, ?User $user = null): User
    {
        try {
            $user ??= $this->model;
            $this->ensurePasswordHashed($data);
            $user->fill($data)->save();
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
}
