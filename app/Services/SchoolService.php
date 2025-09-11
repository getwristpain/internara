<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Helpers\Media;
use App\Models\School;
use App\Services\BaseService;
use App\Helpers\LogicResponse;

class SchoolService extends BaseService
{
    public function save(array $data): LogicResponse
    {
        $upload = Media::upload($data['logo_file'] ?? null, 'schools', 'School Logo');
        $logoPath = $upload->getPath();

        if (!empty($logoPath)) {
            $data['logo_path'] = $logoPath;
        }

        return $this->response()
            ->failWhen($upload->getResponse())
            ->then(function ($res) use ($data, $upload) {
                if ($res->fails()) {
                    $upload->drop();
                    return $res;
                }

                return $this->store($data);
            });
    }

    public function store(array $data): LogicResponse
    {
        $school = app(School::class);
        $stored = $school->updateOrCreate(
            ['id' => $data['id']],
            Helper::filterFillable($data, School::class)
        );

        return $this->response()
            ->decide(
                (bool) $stored ?? false,
                'Berhasil menyimpan data sekolah',
                'Gagal menyimpan data sekolah'
            );
    }
}
