@props([
    'type' => 'text',
    'field' => '',
    'label' => null,
    'hint' => null,
    'icon' => 'ion:text',
    'placeholder' => '',
    'required' => false,
    'autofocus' => false,
    'disabled' => false,
    'hidden' => false,
    'class' => null,
    'style' => [],
])

@php
    $id = str(str_replace('.', ' ', $field))->camel()->toString();
    $hasErrors = $errors->has($field);

    $required = $required ? 'required' : '';
    $disabled = $disabled ? 'disabled' : '';
    $autofocus = $autofocus || $hasErrors ? 'autofocus' : '';

    $icon = match ($type) {
        'address' => 'tabler:map-pin-filled',
        'bussiness', 'company' => 'ion:business',
        'date', 'time' => 'mdi:calendar-time',
        'datetime', 'event', 'year' => 'ic:round-event-note',
        'email' => 'eva:email-fill',
        'image' => 'mdi:image',
        'link', 'url' => 'material-symbols:link',
        'password' => 'tabler:lock-filled',
        'person', 'name', 'username' => 'ion:person',
        'tel', 'phone' => 'solar:phone-bold',
        'text', 'textarea' => 'ion:text',
        default => $icon ?? 'ion:text',
    };

    $type = match ($type) {
        'year' => 'number',
        default => $type,
    };

    $style['container'] = [
        'default' => 'wh-full space-y-2 py-2',
        'hidden' => $hidden ? 'hidden' : '',
    ];

    $class .= ' ' . implode(' ', array_values($style['container']));
@endphp

<div class="{{ $class }}">
    @isset($label)
        <x-label for="{{ $id }}" :$hint
            :$required>{{ $label }}</x-label>
    @endisset

    <div class="relative flex w-full items-center">
        @if ($type === 'textarea' || $type === 'address')
            <textarea
                class="input glass {{ $hasErrors ? 'border-red-500 focus:ring-2 focus:ring-red-500 focus:outline-none' : 'focus:ring-1 focus:ring-neutral-200 focus:outline-none' }} min-h-24 w-full text-wrap rounded-xl !border p-2 pl-8 disabled:border-neutral-500 disabled:bg-neutral-200 disabled:text-neutral-400"
                id="{{ $id }}" wire:model="{{ $field }}"
                type="{{ $type }}" placeholder="{{ $placeholder }}"
                {{ $required }} {{ $autofocus }} {{ $disabled }}
                wire:target="{{ $field }}"></textarea>

            <x-icon
                class="z-2 absolute left-3 top-5 -translate-y-1/2 transform text-center text-sm text-neutral-400"
                icon="{{ $icon }}"></x-icon>
        @else
            <input
                class="input glass {{ $hasErrors ? 'border-red-500 focus:ring-2 focus:ring-red-500 focus:outline-none' : 'focus:ring-1 focus:ring-neutral-200 focus:outline-none' }} w-full rounded-xl !border pl-8 disabled:border-neutral-500 disabled:bg-neutral-200 disabled:text-neutral-400"
                id="{{ $id }}" wire:model="{{ $field }}"
                type="{{ $type }}" placeholder="{{ $placeholder }}"
                {{ $required }} {{ $autofocus }} {{ $disabled }}
                wire:target="{{ $field }}" />

            <x-icon
                class="z-2 absolute left-3 top-1/2 -translate-y-1/2 transform text-center text-sm text-neutral-400"
                icon="{{ $icon }}"></x-icon>
        @endif
    </div>

    @if ($hasErrors)
        <x-input.errors :$field></x-input.errors>
    @endif
</div>
