<?php

namespace App\Services;

use App\Models\Location;

/**
 * Service untuk menangani operasi data lokasi wilayah.
 */
class LocationService extends Service
{
    /**
     * Konstruktor LocationService.
     */
    public function __construct()
    {
        parent::__construct(new Location());
    }

    /**
     * Menyisipkan data lokasi ke database.
     *
     * @param array $data
     * @param int|null $parentId
     * @param string $type
     * @return bool
     */
    public function insert(array $data, ?int $parentId, string $type): bool
    {
        $validate = $this->validate(
            ['data' => $data, 'parent_id' => $parentId, 'type' => $type],
            [
                'data.*.id' => 'required|string',
                'data.*.name' => 'required|string|max:255',
                'data.*.postal_code' => 'sometimes|nullable|string|max:10',
                'parent_id' => 'nullable|integer',
                'type' => 'required|string|in:province,regency,district,village',
            ]
        );

        if ($validate->fails()) {
            $validate->storeLog();
            return false;
        }

        $insert = $this->model()->query()->insert(
            array_map(fn ($item) => [
                'parent_id' => $parentId,
                'name' => $item['name'],
                'type' => $type,
                'postal_code' => $item['postal_code'] ?? null,
            ], $data)
        );

        return $insert ? true : false;
    }

    /**
     * Mencari ID lokasi berdasarkan kriteria.
     *
     * @param array $where
     * @return int|null
     */
    public function findId(array $where): ?int
    {
        return $this->model()->first($where)?->id ?? null;
    }
}
