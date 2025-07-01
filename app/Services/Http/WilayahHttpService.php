<?php

namespace App\Services\Http;

use App\Helpers\Fetch;
use App\Services\Service;
use Illuminate\Support\Collection;

/**
 * ------------------------------------------------------------------------
 * Wilayah HTTP Service
 * ------------------------------------------------------------------------
 * Provides access to Indonesian administrative data from external API.
 */
class WilayahHttpService extends Service
{
    /**
     * ------------------------------------------------------------------------
     * Configuration
     * ------------------------------------------------------------------------
     * Base URL of the external wilayah API.
     *
     * @var string
     */
    protected string $baseUrl = 'https://wilayah.id/api/';

    /**
     * ------------------------------------------------------------------------
     * Constructor
     * ------------------------------------------------------------------------
     * Initializes the service instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ------------------------------------------------------------------------
     * Get Provinces
     * ------------------------------------------------------------------------
     * Retrieves a list of provinces.
     *
     * @return Collection<int, array{id: string, name: string, postal_code: string|null, meta: array}>
     */
    public function getProvinces(): Collection
    {
        return $this->fetchData('provinces');
    }

    /**
     * ------------------------------------------------------------------------
     * Get Regencies
     * ------------------------------------------------------------------------
     * Retrieves a list of regencies by province ID.
     *
     * @param string $provinceId
     * @return Collection<int, array{id: string, name: string, postal_code: string|null, meta: array}>
     */
    public function getRegencies(string $provinceId): Collection
    {
        return $this->fetchDataIfNotEmpty($provinceId, "regencies/{$provinceId}");
    }

    /**
     * ------------------------------------------------------------------------
     * Get Districts
     * ------------------------------------------------------------------------
     * Retrieves a list of districts by regency ID.
     *
     * @param string $regencyId
     * @return Collection<int, array{id: string, name: string, postal_code: string|null, meta: array}>
     */
    public function getDistricts(string $regencyId): Collection
    {
        return $this->fetchDataIfNotEmpty($regencyId, "districts/{$regencyId}");
    }

    /**
     * ------------------------------------------------------------------------
     * Get Villages
     * ------------------------------------------------------------------------
     * Retrieves a list of villages by district ID.
     *
     * @param string $districtId
     * @return Collection<int, array{id: string, name: string, postal_code: string|null, meta: array}>
     */
    public function getVillages(string $districtId): Collection
    {
        return $this->fetchDataIfNotEmpty($districtId, "villages/{$districtId}", true);
    }

    /**
     * ------------------------------------------------------------------------
     * Get Postal Code
     * ------------------------------------------------------------------------
     * Retrieves the postal code based on location information.
     *
     * @param array{id_district?: string, subdistrict_id?: string} $location
     * @return string|null
     */
    public function getPostalCode(array $location = []): ?string
    {
        $districtId = $location['district_id'] ?? '';
        $subdistrictId = $location['subdistrict_id'] ?? '';

        return $this->getVillages($districtId)
            ->firstWhere('id', $subdistrictId)['postal_code'] ?? null;
    }

    /**
     * ------------------------------------------------------------------------
     * Fetch Data
     * ------------------------------------------------------------------------
     * Fetches data from the external API and transforms it.
     *
     * @param string $endpoint
     * @param bool $includePostalCode
     * @return Collection<int, array{id: string, name: string, postal_code: string|null, meta: array}>
     */
    private function fetchData(string $endpoint, bool $includePostalCode = false): Collection
    {
        $response = Fetch::sync("{$this->baseUrl}{$endpoint}.json");

        if (isset($response['errors'])) {
            return collect();
        }

        $meta = $response['meta'] ?? [];

        return collect($response['data'] ?? [])->map(function ($item) use ($includePostalCode, $meta) {
            return [
                'id' => $item['code'] ?? '',
                'name' => $item['name'] ?? '',
                'postal_code' => $includePostalCode ? ($item['postal_code'] ?? '') : null,
                'meta' => $meta,
            ];
        })->filter(fn ($item) => !empty($item['name']));
    }

    /**
     * ------------------------------------------------------------------------
     * Fetch Data If Not Empty
     * ------------------------------------------------------------------------
     * Fetches data only if the parent ID is not empty.
     *
     * @param string|null $parentId
     * @param string $endpoint
     * @param bool $includePostalCode
     * @return Collection<int, array{id: string, name: string, postal_code: string|null, meta: array}>
     */
    private function fetchDataIfNotEmpty(?string $parentId, string $endpoint, bool $includePostalCode = false): Collection
    {
        return empty($parentId)
            ? collect()
            : $this->fetchData($endpoint, $includePostalCode);
    }
}
