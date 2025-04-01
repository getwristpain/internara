<?php

namespace App\Services;

use App\Helpers\Async;
use App\Helpers\Formatter;
use Illuminate\Support\Collection;

class AddressService extends Service
{
    protected int $cacheTTL = 604800;

    public function getProvinces(): Collection
    {
        return $this->fetchData('provinces');
    }

    public function getRegencies(string $provinceId): Collection
    {
        return $this->fetchDataIfNotEmpty($provinceId, "regencies/{$provinceId}", "regencies_{$provinceId}");
    }

    public function getDistricts(string $regencyId): Collection
    {
        return $this->fetchDataIfNotEmpty($regencyId, "districts/{$regencyId}", "districts_{$regencyId}");
    }

    public function getSubdistricts(string $districtId): Collection
    {
        return $this->fetchDataIfNotEmpty($districtId, "villages/{$districtId}", "villages_{$districtId}", true);
    }

    public function getPostalCode(array $location = []): ?string
    {
        return $this->getSubdistricts($location['district_id'] ?? '')
            ->firstWhere('id', $location['subdistrict_id'] ?? '')['postal_code'] ?? null;
    }

    public function getFullAddress(...$address): string
    {
        return implode(', ', array_filter($address));
    }

    public function getAddressOptions(array $location): array
    {
        return collect([
            'provinces' => $this->getProvinces(),
            'regencies' => $this->getRegencies($location['province_id'] ?? ''),
            'districts' => $this->getDistricts($location['regency_id'] ?? ''),
            'subdistricts' => $this->getSubdistricts($location['district_id'] ?? ''),
        ])->map(fn ($data) => Formatter::formatOptions($data->toArray()))->all();
    }

    private function fetchData(string $endpoint, ?string $cacheKey = null, bool $includePostalCode = false): Collection
    {
        $cacheKey ??= $endpoint;

        $data = Async::fetch($cacheKey, "https://wilayah.id/api/{$endpoint}.json", $this->cacheTTL);

        return isset($data['error'])
            ? collect([])
            : collect($data['data'] ?? [])->map(fn ($item) => [
                'id' => $item['code'] ?? '',
                'name' => $item['name'] ?? '',
                'postal_code' => $includePostalCode ? ($item['postal_code'] ?? '') : null,
                'meta' => $data['meta'] ?? [],
            ])->filter();
    }

    private function fetchDataIfNotEmpty(?string $id, string $endpoint, ?string $cacheKey = null, bool $includePostalCode = false): Collection
    {
        return empty($id) ? collect([]) : $this->fetchData($endpoint, $cacheKey, $includePostalCode);
    }
}
