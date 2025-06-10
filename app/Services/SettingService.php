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

    public function rules(): array
    {
        return [
            'app_name' => 'sometimes|required|string|max:255',
            'logo_path' => 'sometimes|nullable|string|max:255',
            'logo_file' => 'sometimes|nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'is_installed' => 'sometimes|required|boolean',
        ];
    }

    public function store(array $values = []): LogicResponse
    {
        $validate = $this->validate($values);

        if ($validate->fails()) {
            return $validate;
        }

        $values['logo_path'] = Media::upload($values['logo_file'] ?? null, 'settings', 'Logo')
            ->getPath();

        $this->model()->set([
            'app_name' => $values['app_name'] ?? null,
            'logo_path' => $values['logo_path'] ?? null,
            'is_installed' => $values['is_installed'] ?? false,
        ]);
    }
}
