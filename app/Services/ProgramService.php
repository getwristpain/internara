<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Program;
use App\Services\Service;

class ProgramService extends Service
{
    protected SchoolService $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
    }

    public function getAll(int $perPage = 10, bool $withoutPagination = false)
    {
        $query = Program::query()
            ->latest();

        if ($withoutPagination) {
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    public function find(string|int|null $id): ?Program
    {
        if (!$id) {
            return null;
        }

        return Program::find($id);
    }

    public function save(array $data, ?Program $program = null)
    {
        $program ??= new Program();
        $school = $this->schoolService->first();

        try {
            $data['school_id'] ??= $school?->id;

            $program->fill($data)->save();

            return $program;
        } catch (\Throwable $th) {
            throw new AppException(
                'Gagal menyimpan program PKL.',
                'Failed to save program: ' . $th->getMessage(),
                previous: $th
            );
        }
    }

    public function delete(string|int|null $id): bool
    {
        if (!$id) {
            return true;
        }

        if (Program::destroy($id)) {
            return true;
        }

        return false;
    }
}
