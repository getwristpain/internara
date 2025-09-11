<?php

namespace App\Livewire\Forms;

use App\Helpers\LogicResponse;
use App\Models\Profile;
use App\Services\ProfileService;
use Livewire\Form;

class ProfileForm extends Form
{
    public array $data = [];

    public array $options = [];

    public function initialize()
    {
        $user = auth()->user();
        $profile = $user->profile();

        $this->data = array_merge(
            $user->only(['name']),
            $profile->first()?->toArray() ?? [],
            [
                'avatar_file' => null,
                'avatar_url' => $user->avatar_url ? asset($user->avatar_url) : null,
            ],
        );

        $this->options['emergency_relation'] = Profile::getEmergencyRelationOptions();
    }

    public function submit(): LogicResponse
    {
        $this->validate([
            'data.name' => 'required|string|max:50',
            'data.avatar_url' => 'nullable|string',
            'data.avatar_file' => 'nullable|image|max:2048',
            'identity' => 'required|unique:profiles,identity,' . $this->data['id'],
            'position' => 'sometimes|nullable|string|max:50',
            'address' => 'required|string|max:1000',
            'postal_code' => 'required|string|min:5',
            'phone' => 'required|string|min:8|max:15',
            'emergency_name' => 'required|string|max:50',
            'emergency_relation' => 'required|string',
            'emergency_address' => 'required|string|max:1000',
            'emergency_phone' => 'required|string|min:8|max:15',
        ]);

        return app(ProfileService::class)
            ->save($this->data, auth()->user());
    }
}
