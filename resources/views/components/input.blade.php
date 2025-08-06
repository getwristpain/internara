@props([
    'class' => null,
    'type' => 'text',
    'field' => '',
    'label' => null,
    'hint' => null,
    'placeholder' => '',
    'required' => false,
    'autofocus' => false,
    'disabled' => false,
    'icon' => 'lucide:form-input',
])

@php
    $name = str(str_replace('.', ' ', $field))->camel()->toString();
    $hasErrors = $errors->has($field);
    $autofocus = $autofocus || $hasErrors ? 'autofocus' : '';
    $required = $required ? 'required' : '';
    $disabled = $disabled ? 'disabled cursor-default' : '';

    $icon = match ($type) {
        'name', 'username' => 'ion:person',
        'email' => 'eva:email-fill',
        'password' => 'tabler:lock-filled',
        default => $icon,
    };

    $labelClass = 'label pl-2 space-x-0 gap-0';

    $class = implode(' ', array_values(array_filter(['wh-full space-y-2', $class])));

@endphp

<div class="{{ $class }}">
    @isset($label)
        <label class="{{ $labelClass }}" for="{{ $name }}">
            <span>{{ $label }}</span>
            <span class="{{ $required }}"></span>

            @isset($hint)
                <span class="text-gray-500 pl-1">({{ $hint }})</span>
            @endisset
        </label>
    @endisset

    <div class="relative flex items-center w-full">
        <input
            class="input pl-8 w-full glass rounded-full !border disabled:bg-gray-200 disabled:text-gray-400 {{ $hasErrors ? 'border-error focus:ring-2 focus:ring-error focus:outline-none' : 'focus:ring-1 focus:ring-gray-200 focus:outline-none' }}"
            id="{{ $name }}" wire:model="{{ $field }}" type="{{ $type }}"
            placeholder="{{ $placeholder }}" {{ $required }} {{ $autofocus }} {{ $disabled }}
            wire:target="{{ $field }}" />

        <iconify-icon
            class="absolute text-sm text-center text-gray-400 left-3 top-1/2 transform
            -translate-y-1/2 z-[2]"
            icon="{{ $icon }}"></iconify-icon>
    </div>
    <div class="flex flex-col pt-1 w-full">
        @if ($hasErrors)
            @foreach ($errors->get($field) as $error)
                <span class="text-error font-semibold text-sm">{{ $error }}</span>
            @endforeach
        @endif
    </div>
</div>
