<?php

namespace App\Services;

use App\Models\Location;

/**
 * ------------------------------------------------------------------------
 * LocationService
 * ------------------------------------------------------------------------
 * Service to manage Indonesian administrative location data.
 */
class LocationService extends Service
{
    /**
     * LocationService constructor.
     */
    public function __construct()
    {
        parent::__construct(new Location());
    }

    /**
     * Upsert a batch of location data into the database.
     *
     * @param array $items
     * @param int|null $parentId
     * @param string $type
     * @return bool
     */
    public function upsert(array $items, ?int $parentId, string $type): bool
    {
        $validation = $this->validate(
            [
                'items' => $items,
                'parent_id' => $parentId,
                'type' => $type,
            ],
            [
                'items.*.id' => 'required|string',
                'items.*.name' => 'required|string|max:255',
                'items.*.postal_code' => 'nullable|string|max:10',
                'parent_id' => 'nullable|integer',
                'type' => 'required|string|in:province,regency,district,village',
            ]
        );

        if ($validation->fails()) {
            $validation->storeLog();
            return false;
        }

        $payload = array_map(fn (array $item) => [
                'parent_id' => $parentId,
                'name' => $item['name'],
                'type' => $type,
                'postal_code' => $item['postal_code'] ?? null,
            ], $items);

        return $this->model()->query()->upsert(
            $payload,
            ['parent_id', 'type', 'name'],
            ['postal_code']
        );
    }

    /**
     * Find the ID of a location by the given conditions.
     *
     * @param array $conditions
     * @return int|null
     */
    public function findId(array $conditions): ?int
    {
        return $this->model()->first($conditions)?->id;
    }
}
