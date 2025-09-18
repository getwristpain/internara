<?php

namespace App\Services;

use App\Helpers\Media;
use App\Models\School;
use App\Services\BaseService;
use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class SchoolService extends BaseService
{
    /**
     * @var School|null The school instance to operate on.
     */
    protected ?School $school = null;

    // ---

    /**
     * Sets the school instance to be used by other methods.
     *
     * @param School|null $school The school instance.
     * @return self
     */
    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Retrieves the first school record.
     *
     * @return School|null
     */
    public function get(): ?School
    {
        return $this->school ?? School::first();
    }

    /**
     * Saves the school data, including logo upload.
     *
     * @param array $data The data for the school.
     * @return LogicResponse
     */
    public function save(array $data): LogicResponse
    {
        try {
            $upload = Media::upload($data['logo_file'] ?? null, 'schools', 'School Logo');

            if ($upload->hasError()) {
                return $this->respond(false, $upload->getErrorMessage());
            }

            DB::beginTransaction();

            $school = $this->school ?? new School();

            if ($upload->isSuccessful()) {
                if ($school->exists && !empty($school->logo_path)) {
                    Media::delete($school->logo_url);
                }
                $data['logo_path'] = $upload->getStoragePath();
            }

            $saved = $school->fill($data)->save();

            if (!$saved) {
                DB::rollBack();
                if ($upload->isSuccessful()) {
                    $upload->drop();
                }
                return $this->respond(false, 'Gagal menyimpan data sekolah.');
            }

            DB::commit();
            return $this->respond(true, 'Berhasil menyimpan data sekolah.', ['school' => $school]);

        } catch (Throwable $th) {
            DB::rollBack();
            return $this->respond(false, 'Gagal menyimpan data sekolah.')->debug($th);
        }
    }
}
