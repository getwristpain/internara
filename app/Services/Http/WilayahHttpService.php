<?php

namespace App\Services\Http;

use App\Helpers\Fetch;
use App\Services\Service;
use Illuminate\Support\Collection;

/**
 * Service untuk mengambil data wilayah administratif Indonesia dari API eksternal.
 */
class WilayahHttpService extends Service
{
    protected string $baseUrl = 'https://wilayah.id/api/';

    /**
     * Konstruktor WilayahHttpService.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mengambil daftar provinsi.
     *
     * @return Collection
     */
    public function getProvinces(): Collection
    {
        return $this->fetchData('provinces');
    }

    /**
     * Mengambil daftar kabupaten/kota berdasarkan ID provinsi.
     *
     * @param string $provinceId
     * @return Collection
     */
    public function getRegencies(string $provinceId): Collection
    {
        return $this->fetchDataIfNotEmpty($provinceId, "regencies/{$provinceId}");
    }

    /**
     * Mengambil daftar kecamatan berdasarkan ID kabupaten/kota.
     *
     * @param string $regencyId
     * @return Collection
     */
    public function getDistricts(string $regencyId): Collection
    {
        return $this->fetchDataIfNotEmpty($regencyId, "districts/{$regencyId}");
    }

    /**
     * Mengambil daftar desa/kelurahan berdasarkan ID kecamatan.
     *
     * @param string $districtId
     * @return Collection
     */
    public function getVillages(string $districtId): Collection
    {
        return $this->fetchDataIfNotEmpty($districtId, "villages/{$districtId}", true);
    }

    /**
     * Mengambil kode pos berdasarkan lokasi.
     *
     * @param array $location
     * @return string|null
     */
    public function getPostalCode(array $location = []): ?string
    {
        return $this->getVillages($location['district_id'] ?? '')
            ->firstWhere('id', $location['subdistrict_id'] ?? '')['postal_code'] ?? null;
    }

    /**
     * Mengambil data dari endpoint API wilayah.
     *
     * @param string $endpoint
     * @param bool $includePostalCode
     * @return Collection
     */
    private function fetchData(string $endpoint, bool $includePostalCode = false): Collection
    {
        $data = Fetch::sync("{$this->baseUrl}{$endpoint}.json");

        return isset($data['errors'])
            ? collect()
            : collect($data['data'] ?? [])->map(fn ($item) => [
                'id' => $item['code'] ?? '',
                'name' => $item['name'] ?? '',
                'postal_code' => $includePostalCode ? ($item['postal_code'] ?? '') : null,
                'meta' => $data['meta'] ?? [],
            ])->filter(fn ($item) => !empty($item['name']));
    }

    /**
     * Mengambil data dari endpoint jika ID tidak kosong.
     *
     * @param string|null $id
     * @param string $endpoint
     * @param bool $includePostalCode
     * @return Collection
     */
    private function fetchDataIfNotEmpty(?string $id, string $endpoint, bool $includePostalCode = false): Collection
    {
        return empty($id) ? collect([]) : $this->fetchData($endpoint, $includePostalCode);
    }
}
