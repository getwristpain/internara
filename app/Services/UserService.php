<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService
{
    public function storeUser(array $data): LogicResponse
    {
        $type = $data['type'];

        $this->ensureUsernameFilled($data['username'], $data['email'], $data['id']);
        $this->ensurePasswordHashed($data['password']);

        $storedUser = $data['type'] === 'owner'
            ? User::updateOrCreate(['id' => $data['id'] ?? ''], $data)
            : User::create($data);
        $storedUser->syncRoles($type === 'owner' ? ['owner', 'admin'] : $type);

        return $this->response()->decide(
            (bool) $storedUser ?? false,
            'Akun pengguna berhasil dibuat.',
            'Gagal menyimpan akun pengguna.'
        );
    }

    public function ensureUsernameFilled(?string &$ref, ?string $default, string|int|null $id = null): void
    {
        $ref ??= $default;

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
