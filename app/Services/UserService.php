<?php

namespace App\Services;

use App\Helpers\Generator;
use App\Helpers\LogicResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{
    /**
     * @var User|null The user model instance for subsequent operations.
     */
    private ?User $user = null;

    /**
     * Sets the user model instance for subsequent operations.
     *
     * @param User|null $user
     * @return static
     */
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Saves a new user or updates an existing one.
     *
     * @param array $data
     * @return LogicResponse
     */
    public function save(array $data): LogicResponse
    {
        try {
            $this->ensureUsernameFilled($data);
            $this->ensurePasswordHashed($data);

            $user = $this->user ?? new User();
            $user->fill($data)->save();

            if (isset($data['roles'])) {
                $user->syncRoles($data['roles'] ?? 'student');
            }

            if (isset($data['statuses'])) {
                $user->syncStatuses($data['statuses'] ?? 'pending-activation', 'user');
            }

            return $this->respond(true, 'Berhasil menyimpan data pengguna.', ['user' => $user]);
        } catch (\Throwable $th) {
            return $this->respond(false, 'Gagal menyimpan data pengguna.')->debug($th);
        }
    }

    /**
     * Ensures the username is filled, generating one if it's empty.
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function ensureUsernameFilled(array &$data): void
    {
        $type = $data['type'] ?? 'guest';

        $prefix = match ($type) {
            'admin', 'owner' => 'adm',
            'student' => 'st',
            'teacher' => 'te',
            'supervisor' => 'sv',
            default => 'u',
        };

        $data['username'] ??= Generator::username($prefix);

        $validator = Validator::make(
            data: ['username' => $data['username']],
            rules: ['username' => 'required|string|min:5|unique:users,username,' . ($this->user->id ?? '')],
            attributes: ['username' => 'username pengguna']
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Ensures the password is hashed if it's not already.
     *
     * @param array $data
     * @return void
     */
    private function ensurePasswordHashed(array &$data): void
    {
        if (isset($data['password']) && !str_starts_with($data['password'], '$2y$')) {
            $data['password'] = Hash::make($data['password']);
        }
    }
}
