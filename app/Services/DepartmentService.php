<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\Department;
use App\Models\School;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class DepartmentService extends BaseService
{
    /**
     * Retrieves all departments, ordered by name.
     *
     * @return array
     */
    public function getAll(): array
    {
        $departments = Department::query()
            ->orderBy('name')
            ->get();

        return $departments->map(
            fn ($dept) => $dept->only(['id', 'name', 'description']),
        )->toArray();
    }

    /**
     * Creates a new department.
     *
     * @param array $data The data for the new department.
     * @return LogicResponse
     */
    public function create(array $data): LogicResponse
    {
        try {
            $data['school_id'] ??= School::first()?->id;

            $fillableData = collect($data)->only(app(Department::class)->getFillable());
            $department = Department::create($fillableData->toArray());

            return $this->respond(true, 'Berhasil menambahkan jurusan.', ['department' => $department]);
        } catch (Throwable $th) {
            return $this->respond(false, 'Gagal menambahkan jurusan.')->debug($th);
        }
    }

    /**
     * Deletes one or more departments.
     *
     * @param Collection|array|string|int $ids The ID(s) of the department(s) to delete.
     * @return LogicResponse
     */
    public function delete(Collection|array|string|int $ids): LogicResponse
    {
        try {
            $deletedCount = Department::destroy($ids);

            if ($deletedCount > 0) {
                return $this->respond(true, "Berhasil menghapus {$deletedCount} jurusan.");
            }

            return $this->respond(false, 'Tidak ada jurusan yang dihapus.');
        } catch (Throwable $th) {
            return $this->respond(false, 'Gagal menghapus jurusan.')->debug($th);
        }
    }
}
