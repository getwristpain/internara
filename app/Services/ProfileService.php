<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Helpers\Media;
use App\Helpers\Support;
use App\Models\Profile;
use App\Models\User;
use App\Services\BaseService;

class ProfileService extends BaseService
{
    public function save(array $data = [], ?User $user = null): LogicResponse
    {
        $profile = $user->profile();
        $handleAvatar = Media::upload($data['avatar_file'], 'users/' . $user->id, 'Avatar');

        $updatedUser = (bool) $user->update([
            'name' => $data['name'],
            'avatar_url' => $handleAvatar->getPath() ?: $data['avatar_url'],
        ]) ?? false;

        $updatedProfile = (bool) $profile->updateOrCreate(
            ['id' => $data['id']],
            Support::filterFillable($data, Profile::class)
        ) ?? false;

        return $this->respond()
            ->failWhen($handleAvatar->getResponse())
            ->failWhen(!$updatedUser && !$updatedProfile, 'Gagal menyimpan profil pengguna.')
            ->then(function ($res) use ($handleAvatar) {
                if ($res->fails()) {
                    $handleAvatar?->drop();
                    return $res;
                }

                return $res->success('Berhasil menyimpan profil pengguna.');
            });
    }
}
