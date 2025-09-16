<?php

namespace App\Services;

use App\Helpers\Generator;
use App\Helpers\LogicResponse;
use App\Helpers\Helper;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{
    public function save(array $data, ?User $user = null): LogicResponse
    {
        $type = $data['type'] ?? 'guest';

        $this->ensureUsernameFilled($type, $data['username'], $data['id']);
        $this->ensurePasswordHashed($data['password']);

        // Use existing User model
        $saved = isset($user) && $user?->exists
            ? $user->update(Helper::filterOnly($data, $user->getFillable()))
            : $user = User::create(Helper::filterOnly($data, app(User::class)->getFillable()));

        // Sync Roles when roles data is set
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles'] ?? 'guest');
        }

        // Sync Statuses when statuses data is set
        if (isset($data['statuses'])) {
            $user->syncStatuses($data['statuses'] ?? 'pending-activation', 'user');
        }

        return $this->response()->decide(
            (bool) $saved ?? false,
            'Akun pengguna berhasil dibuat.',
            'Gagal menyimpan akun pengguna.'
        );
    }

    public function ensureUsernameFilled(string $type, ?string &$ref, string|int|null $id = null): void
    {
        $prefix = match ($type) {
            'admin', 'owner' => 'adm',
            'student' => 'st',
            'teacher' => 'te',
            'supervisor' => 'sv',
            default => 'u',
        };

        $ref ??= Generator::username($prefix);

        $validator = Validator::make(
            data: ['username' => $ref],
            rules: ['username' => 'required|string|min:5|unique:users,username,' . $id],
            attributes: ['username' => 'username pengguna']
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function ensurePasswordHashed(?string &$ref): void
    {
        if (!str_starts_with($ref, '$2y$')) {
            $ref = Hash::make($ref);
        }
    }
}
