<?php

namespace App\Services;

use App\Services\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AddressService extends Service
{
    protected int $cacheTTL = 86400;

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
        return $this->fetchData("regencies/{$provinceId}", "regencies_{$provinceId}");
    }

    public function getDistricts(string $regencyId): Collection
    {
        return $this->fetchData("districts/{$regencyId}", "districts_{$regencyId}");
    }

    public function getVillages(string $districtId): Collection
    {
        return $this->fetchData("villages/{$districtId}", "villages_{$districtId}", true);
    }

    public function getPostalCode(string $villageId): string
    {
        return $this->fetchData("villages/{$villageId}", "villages_{$villageId}", true)->first()['postal_code'] ?? '';
    }

    public function getFullAddress(...$address): string
    {
        return implode(', ', array_filter($address));
    }

    private function fetchData(string $endpoint, ?string $cacheKey = null, bool $includePostalCode = false): Collection
    {
        try {
            $cacheKey ??= $endpoint;

            return Cache::remember($cacheKey, $this->cacheTTL, function () use ($endpoint, $includePostalCode) {
                $response = Http::get("https://wilayah.id/api/{$endpoint}.json");
                if ($response->failed()) return collect([]);

                $json = $response->json();
                $meta = $json['meta'] ?? [];

                return collect($json['data'] ?? [])->map(fn($item) => array_merge([
                    'id' => $item['code'] ?? '',
                    'name' => $item['name'] ?? '',
                ], $includePostalCode ? ['postal_code' => $item['postal_code'] ?? ''] : [], ['meta' => $meta]));
            });
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to fetch address data.', $th);
            throw $th;
        }
    }
}
