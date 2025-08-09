@props([
    'autofocus' => false,
    'class' => null,
    'disabled' => false,
    'field' => '',
    'hint' => null,
    'icon' => 'icon-park-outline:text',
    'label' => null,
    'placeholder' => '',
    'required' => false,
    'type' => 'text',
])

@php
    $id = str(str_replace('.', ' ', $field))->camel()->toString();
    $hasErrors = $errors->has($field);
    $autofocus = $autofocus || $hasErrors ? 'autofocus' : '';
    $required = $required ? 'required' : '';
    $disabled = $disabled ? 'disabled cursor-default' : '';

    $icon = match ($type) {
        'address' => 'tabler:map-pin-filled',
        'bussiness', 'company' => 'ion:business',
        'email' => 'eva:email-fill',
        'image' => 'mdi:image',
        'link', 'url' => 'material-symbols:link',
        'password' => 'tabler:lock-filled',
        'person', 'name', 'username' => 'ion:person',
        'tel', 'phone' => 'solar:phone-bold',
        'text' => 'icon-park-outline:text',
        default => $icon ?? 'icon-park-outline:text',
    };

    $class = implode(' ', array_values(array_filter(['wh-full space-y-2', $class])));
@endphp

<div class="{{ $class }}">
    @isset($label)
        <x-label for="{{ $id }}" :$hint :$required>{{ $label }}</x-label>
    @endisset

    <div class="relative flex items-center w-full">
        <input
            class="input pl-8 w-full glass rounded-full !border disabled:bg-gray-200 disabled:text-gray-400 {{ $hasErrors ? 'border-error focus:ring-2 focus:ring-error focus:outline-none' : 'focus:ring-1 focus:ring-gray-200 focus:outline-none' }}"
            id="{{ $id }}" wire:model="{{ $field }}" type="{{ $type }}"
            placeholder="{{ $placeholder }}" {{ $required }} {{ $autofocus }} {{ $disabled }}
            wire:target="{{ $field }}" />

        <iconify-icon
            class="absolute text-sm text-center text-gray-400 left-3 top-1/2 transform
            -translate-y-1/2 z-[2]"
            icon="{{ $icon }}"></iconify-icon>
    </div>

    @if ($hasErrors)
        <div class="flex flex-col pt-1 w-full">
            @foreach ($errors->get($field) as $error)
                <span class="text-error font-semibold text-sm">{{ $error }}</span>
            @endforeach
        </div>
    @endif
</div>
