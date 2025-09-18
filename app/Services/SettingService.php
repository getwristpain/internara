<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Helpers\Media;
use App\Models\Setting;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class SettingService extends BaseService
{
    /**
     * @var int The default TTL for cached settings in seconds.
     */
    protected const CACHE_TTL = 3600;

    /**
     * @var array The casting rules for setting values.
     */
    private const CASTS = [
        'brand_logo' => 'asset',
    ];


    /**
     * Retrieves all settings from the database.
     *
     * @return Collection|null
     */
    public function all(): ?Collection
    {
        try {
            return Setting::all();
        } catch (Throwable $th) {
            $this->respond(false, 'Gagal mengambil semua pengaturan.')->debug($th);
            return null;
        }
    }

    /**
     * Retrieves one or more settings by key(s) and applies casting.
     *
     * @param string|array $keys The key(s) of the setting(s).
     * @param mixed $default The default value(s) if a key is not found.
     * @return mixed
     */
    public function get(string|array $keys, mixed $default = null): mixed
    {
        try {
            $isInstalled = $this->isInstalled();

            if (is_string($keys)) {
                $defaultBranding = !$isInstalled ? $this->checkBrandingDefault($keys) : null;
                $value = $defaultBranding ?? Setting::where('key', $keys)->first()?->value ?? $default;

                return $this->castValue($keys, $value);
            }

            $models = Setting::query()->whereIn('key', $keys)->pluck('value', 'key');
            $values = collect($keys)->mapWithKeys(function ($key) use ($models, $default, $isInstalled) {
                $defaultBranding = !$isInstalled ? $this->checkBrandingDefault($key) : null;
                $value = $defaultBranding ?? Arr::get($models, $key, Arr::get($default, $key, null));

                return [$key => $this->castValue($key, $value)];
            })->toArray();

            return $values;
        } catch (Throwable $th) {
            $this->respond(false, 'Gagal mengambil pengaturan.')->debug($th);
            return null;
        }
    }

    /**
     * Retrieves and caches one or more settings by key(s).
     *
     * @param string|array $keys The key(s) of the setting(s).
     * @param mixed $default The default value(s) if a key is not found.
     * @param int|null $ttl The TTL for the cache in seconds.
     * @return mixed
     */
    public function cached(string|array $keys, mixed $default = null, ?int $ttl = null): mixed
    {
        $ttl ??= self::CACHE_TTL;

        try {
            if (is_array($keys)) {
                $values = collect($keys)->mapWithKeys(fn ($key) => [
                    $key => Cache::remember(
                        "settings.{$key}",
                        $ttl,
                        fn () => $this->get($key, Arr::get($default, $key))
                    )
                ])->all();
                return $values;
            }

            return Cache::remember(
                "settings.{$keys}",
                $ttl,
                fn () => $this->get($keys, $default)
            );
        } catch (Throwable $th) {
            $this->respond(false, 'Gagal mengambil pengaturan dari cache.')->debug($th);
            return null;
        }
    }

    /**
     * Sets one or more settings.
     *
     * @param string|array $keys The key (string) or an associative array of keys and values.
     * @param mixed $value The value of the setting (if $keys is a string).
     * @return LogicResponse
     */
    public function set(string|array $keys, mixed $value = null): LogicResponse
    {
        try {
            if (is_array($keys)) {
                if (!Arr::isAssoc($keys)) {
                    throw new \InvalidArgumentException('The $keys parameter must be an associative array.');
                }

                DB::beginTransaction();
                foreach ($keys as $key => $val) {
                    $this->set($key, $val);
                }
                DB::commit();

                return $this->respond(true, 'Berhasil menyimpan beberapa pengaturan.');
            }

            $setting = Setting::updateOrCreate(
                ['key' => $keys],
                ['value' => $value]
            );

            Cache::put("settings.{$keys}", $value, now()->addSeconds(self::CACHE_TTL));
            return $this->respond(true, 'Berhasil menyimpan pengaturan.', ['setting' => $setting]);
        } catch (Throwable $th) {
            DB::rollBack();
            return $this->respond(false, 'Gagal menyimpan pengaturan.')->debug($th);
        }
    }

    /**
     * Checks if the application is in an installed state.
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return (bool)Setting::where('key', 'is_installed')->first()?->value ?? false;
    }


    /**
     * Casts a value based on a given key.
     *
     * @param string $key The setting key.
     * @param mixed $value The value to cast.
     * @return mixed
     */
    protected function castValue(string $key, mixed $value): mixed
    {
        $cast = self::CASTS[$key] ?? null;

        if ($cast === null) {
            return $value;
        }

        return match ($cast) {
            'asset' => Media::asset($value),
            default => $value,
        };
    }

    /**
     * Checks if a key should use the default branding value.
     *
     * @param string $key
     * @return string|null
     */
    protected function checkBrandingDefault(string $key): ?string
    {
        return match ($key) {
            'brand_name' => config('app.name'),
            'brand_logo' => config('app.logo'),
            default => null,
        };
    }
}
