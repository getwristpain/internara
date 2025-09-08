<?php

namespace App\Services;

use App\Helpers\Generator;
use App\Helpers\LogicResponse;
use App\Helpers\Support;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{
    public function store(array $data): LogicResponse
    {
        $type = $data['type'] ?? 'guest';

        $this->ensureUsernameFilled($type, $data['username'], $data['id']);
        $this->ensurePasswordHashed($data['password']);

        $storedUser = $data['type'] === 'owner'
            ? User::updateOrCreate(['id' => $data['id'] ?? ''], Support::filterFillable($data, User::class))
            : User::create(Support::filterFillable($data, User::class));

        $storedUser->syncRoles($type === 'owner' ? ['owner', 'admin'] : $type);
        $storedUser->syncStatuses($type === 'owner' ? 'protected' : 'pending-activation', 'user');

        return $this->response()->decide(
            (bool) $storedUser ?? false,
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
