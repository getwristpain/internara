@props([
    'model' => '',
    'name' => '',
    'label' => '',
    'required' => false,
    'disabled' => false,
])

<div>
    <label
        class="flex items-center cursor-pointer w-fit {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}"
        for="{{ $name }}">
        <input class="checkbox checkbox-sm checkbox-neutral rounded-full" id="{{ $name }}"
            name="{{ $name }}" wire:model.live="{{ $model }}" type="checkbox"
            {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} />
        <span class="pl-2">{{ $label }}</span>
    </label>
</div>
