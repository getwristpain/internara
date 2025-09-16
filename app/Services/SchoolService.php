<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Helpers\Media;
use App\Models\School;
use App\Services\BaseService;
use App\Helpers\LogicResponse;

class SchoolService extends BaseService
{
    public function get(): ?School
    {
        return School::first();
    }

    public function save(array $data, ?School $school = null): LogicResponse
    {
        $upload = Media::upload($data['logo_file'] ?? null, 'schools', 'School Logo');
        $logoPath = $upload->getPath();

        if (!empty($logoPath)) {
            $data['logo_path'] = $logoPath;
        }

        return $this->response()
            ->failWhen($upload->getResponse())
            ->then(function ($res) use ($data, $school, $upload) {
                if ($res->fails()) {
                    $upload->drop();
                    return $res;
                }

                $stored = isset($school) && $school->exists
                    ? $school->update(Helper::filterOnly($data, $school->getFillable()))
                    : $school = School::first()?->update(Helper::filterOnly($data, app(School::class)->getFillable()));

                return $res->decide(
                    (bool) $stored ?? false,
                    'Berhasil menyimpan data sekolah',
                    'Gagal menyimpan data sekolah'
                );
            });
    }
}
