<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\Program;
use App\Models\School;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class ProgramService extends BaseService
{
    /**
     * @var Collection|null A cached collection of all programs.
     */
    protected ?Collection $programs = null;

    /**
     * @var Program|null The program instance to operate on.
     */
    protected ?Program $program = null;

    // ---

    /**
     * Retrieves all programs from the database.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->programs = Program::query()->latest()->get();
    }

    /**
     * Retrieves a single program by its ID.
     *
     * @param string|int $id The ID of the program.
     * @return Program|null
     */
    public function get(string|int $id): ?Program
    {
        return Program::query()->find($id);
    }

    /**
     * Sets the program instance to be used by other methods.
     *
     * @param Program $program
     * @return self
     */
    public function setProgram(Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Saves a new or existing program.
     *
     * @param array $data The data to save.
     * @return LogicResponse
     */
    public function save(array $data): LogicResponse
    {
        try {
            $fillableData = collect($data)->only(app(Program::class)->getFillable());

            $fillableData['school_id'] ??= School::first()?->id;

            $programToSave = $this->program;

            if (isset($programToSave) && $programToSave->exists) {
                $programToSave->update($fillableData->toArray());
            } else {
                $programToSave = Program::create($fillableData->toArray());
            }

            return $this->respond(true, 'Berhasil menyimpan program.', ['program' => $programToSave]);
        } catch (Throwable $th) {
            return $this->respond(false, 'Gagal menyimpan program.')->debug($th);
        }
    }

    /**
     * Deletes one or more programs.
     *
     * @param Collection|array|string|int|null $ids The ID(s) of the program(s) to delete.
     * @return LogicResponse
     */
    public function delete(Collection|array|string|int|null $ids = null): LogicResponse
    {
        try {
            $idsToDelete = $ids;
            if (isset($this->program) && empty($ids)) {
                $idsToDelete = $this->program->id;
            }

            if (empty($idsToDelete)) {
                return $this->respond(false, 'Tidak ada program yang dihapus.');
            }

            $deletedCount = Program::destroy($idsToDelete);

            return $this->respond(true, "Berhasil menghapus {$deletedCount} program.");
        } catch (Throwable $th) {
            return $this->respond(false, 'Gagal menghapus program.')->debug($th);
        }
    }
}
