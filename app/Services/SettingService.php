<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\Setting;

/**
 * Service for application setting management.
 */
class SettingService extends Service
{
    /**
     * SettingService constructor.
     */
    public function __construct()
    {
        parent::__construct(new Setting());
    }

    /**
     * Get setting value by key.
     *
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed
    {
        $setting = $this->model()->first(['key' => $key]);
        return $setting->value ?? $default;
    }

    /**
     * Update or create setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return LogicResponse
     */
    public function set(string $key, mixed $value): LogicResponse
    {
        return $this->model()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Check if the application is installed.
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return (bool) $this->get('is_installed', false);
    }
}
