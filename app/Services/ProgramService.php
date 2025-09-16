<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Helpers\LogicResponse;
use App\Models\Program;
use App\Models\School;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;

class ProgramService extends BaseService
{
    public function getAll(): Collection|array|null
    {
        return Program::query()
            ->latest()
            ->get();
    }

    public function save(array $data, ?Program $program = null, string|int|null $schoolId = null): LogicResponse
    {
        if (!isset($data['school_id'])) {
            $schoolId ??= School::first()?->id;
            $data = array_merge($data, ['school_id' => $schoolId]);
        }

        $stored = isset($program) && $program?->exists
            ? $program->update(Helper::filterOnly($data, app(Program::class)->getFillable()))
            : Program::create(Helper::filterOnly($data, app(Program::class)->getFillable()));

        return $this->response()
            ->decide(
                (bool) $stored ?? false,
                'Berhasil menyimpan program',
                'Gagal menyimpan program'
            );
    }
}
