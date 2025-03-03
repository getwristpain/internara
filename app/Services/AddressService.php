<?php

namespace App\Services;

use App\Helpers\Formatter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

    public function getSubdistricts(string $districtId): Collection
    {
        return $this->fetchData("villages/{$districtId}", "villages_{$districtId}", true);
    }

    public function getPostalCode(array $location = []): ?string
    {
        return $this->getSubdistricts($location['district_id'] ?? '')
            ->where('id', $location['subdistrict_id'] ?? '')
            ->first()['postal_code'] ?? null;
    }

    public function getFullAddress(...$address): string
    {
        return implode(', ', array_filter($address));
    }

    public function getOptions(array $location = [])
    {
        return [
            'provinces' => Formatter::formatOptions($this->getProvinces()->toArray()),
            'regencies' => Formatter::formatOptions($this->getRegencies($location['province_id'] ?? '')->toArray()),
            'districts' => Formatter::formatOptions($this->getDistricts($location['regency_id'] ?? '')->toArray()),
            'subdistricts' => Formatter::formatOptions($this->getSubdistricts($location['district_id'] ?? '')->toArray()),
        ];
    }

    private function fetchData(string $endpoint, ?string $cacheKey = null, bool $includePostalCode = false): Collection
    {
        try {
            $cacheKey ??= $endpoint;

            return Cache::remember($cacheKey, $this->cacheTTL, function () use ($endpoint, $includePostalCode) {
                $response = Http::get("https://wilayah.id/api/{$endpoint}.json");
                if ($response->failed()) {
                    return collect([]);
                }

                $json = $response->json();
                $meta = $json['meta'] ?? [];

                return collect($json['data'] ?? [])->map(fn ($item) => array_merge([
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
