<?php

namespace App\Services\Http;

use App\Helpers\Fetch;
use App\Services\Service;
use Illuminate\Support\Collection;

class WilayahHttpService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getProvinces(): Collection
    {
        return $this->fetchData('provinces');
    }

    public function getRegencies(string $provinceId): Collection
    {
        return $this->fetchDataIfNotEmpty($provinceId, "regencies/{$provinceId}");
    }

    public function getDistricts(string $regencyId): Collection
    {
        return $this->fetchDataIfNotEmpty($regencyId, "districts/{$regencyId}");
    }

    public function getVillages(string $districtId): Collection
    {
        return $this->fetchDataIfNotEmpty($districtId, "villages/{$districtId}", true);
    }

    public function getPostalCode(array $location = []): ?string
    {
        return $this->getVillages($location['district_id'] ?? '')
            ->firstWhere('id', $location['subdistrict_id'] ?? '')['postal_code'] ?? null;
    }

    private function fetchData(string $endpoint, bool $includePostalCode = false): Collection
    {
        $data = Fetch::sync("https://wilayah.id/api/{$endpoint}.json");

        return isset($data['errors'])
            ? collect()
            : collect($data['data'] ?? [])->map(fn ($item) => [
                'id' => $item['code'] ?? '',
                'name' => $item['name'] ?? '',
                'postal_code' => $includePostalCode ? ($item['postal_code'] ?? '') : null,
                'meta' => $data['meta'] ?? [],
            ])->filter(fn ($item) => !empty($item['name']));
    }

    private function fetchDataIfNotEmpty(?string $id, string $endpoint, bool $includePostalCode = false): Collection
    {
        return empty($id) ? collect([]) : $this->fetchData($endpoint, $includePostalCode);
    }
}
