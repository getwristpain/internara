<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Helpers\Media;
use App\Models\School;
use App\Services\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SchoolService extends Service
{
    public function firstSchool(): ?School
    {
        return School::first();
    }

    public function save(array $data, ?School $school = null): ?School
    {
        $school ??= $this->firstSchool();

        try {
            DB::beginTransaction();

            $school->fill($data)->save();

            if (!$data['logo_file']) {
                $school->saveLogo($data['logo_file']);
            }

            DB::commit();

            return $this->firstSchool();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw new AppException(
                'Gagal menyimpan data sekolah.',
                'Failed to save school: ' . $th->getMessage(),
                previous: $th
            );
        }
    }
}
