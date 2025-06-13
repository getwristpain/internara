<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Models\Setting;

class SettingService extends Service
{
    public function __construct()
    {
        parent::__construct(new Setting());
    }

    public function get(string|int $key, $default = null): mixed
    {
        $setting = $this->model()->first(['key' => $key]);
        return $setting->value ?? $default;
    }

    public function set(string $key, mixed $value): LogicResponse
    {
        return $this->model()->update(['value' => $value], ['key' => $key]);
    }

    public function isInstalled(): bool
    {
        return $this->get('is_installed') ?? false;
    }
}
