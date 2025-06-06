<?php

namespace App\Services;

use App\Helpers\LogicResponse;
use App\Helpers\Media;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;

class SettingService extends Service
{
    public function __construct()
    {
        parent::__construct(new Setting(), ['single', 'read', 'update']);
    }

    public function getValues(string|array $keys = ''): mixed
    {
        if (!empty($keys)) {
            if (is_string($keys)) {
                return $this->attributes->$keys;
            }

            $get = [];
            foreach ($keys as $key) {
                $get[$key] = $this->attributes->$key;
            }

            return $get;
        }

        return $this->attributes;
    }

    public function setValues(array $values = []): LogicResponse
    {
        return $this->validate($values, $this->rules())->then()?->model()->set([
            'name' => $values['name'] ?? '',
            'logo' => $values['logo_path'] ?? $values['logo'] ?? '',
            'is_installed' => $values['is_installed'] ?? ''
        ]);
    }

    public function storeSetting(array $values = []): LogicResponse
    {
        $validate = $this->validate($values, array_merge($this->rules(), $this->additionalRules()));

        if ($validate->fails()) {
            return $validate;
        }

        $handleLogo = $this->storeLogo($values['logo_file'] ?? null);

        if ($handleLogo->fails()) {
            return $handleLogo;
        }

        return $this->setValues(array_merge($validate->payload()?->toArray(), $handleLogo->payload()?->toArray()));
    }

    protected function storeLogo(?UploadedFile $logoFile = null): LogicResponse
    {
        $validate = $this->validate(['logo_file' => $logoFile], $this->additionalRules());

        if ($validate->fails()) {
            return $validate;
        }

        $logoPath = Media::upload($logoFile, 'settings', 'Logo')->getPath();
        if (empty($logoPath)) {
            return $this->response()->failure('Failed store logo to storage.')
                ->storeLog();
        }

        return $this->response()->success('Logo stored in storage successfully.')
            ->withPayload(['logo_path' => $logoPath])
            ->operator($this)
            ->storeLog();
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|min:5|max:255',
            'logo' => 'sometimes|nullable|string|max:255',
            'logo_path' => 'sometimes|nullable|string|max:255',
            'is_installed' => 'sometimes|required|boolean',
        ];
    }

    public function additionalRules(): array
    {
        return [
            'logo_file' => 'sometimes|required|image|mimes:jpg,png,webp|max:10240'
        ];
    }

    public function isInstalled(): bool
    {
        return $this->getValues('is_installed') ?? false;
    }

    public function isCompleted(string $name, string $type = ''): bool
    {
        return $this->model()->query()->firstStatus($name, $type)?->flag ?? false;
    }

    public function markStatus(string $name, string $type = '', string $column = 'flag', bool $strict = false): bool
    {
        return $this->model()->query()->markStatus($name, $type, $column, $strict);
    }
}
