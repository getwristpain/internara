@props([
    'attributes' => [],
    'style' => [],
    'class' => '',
    'name' => '',
    'field' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'autofocus' => false,
    'disabled' => false,
    'hidden' => false,
    'icon' => 'ion:text',
])

@php
    // Fallback default name
    $name = $name ?: str($field)->replace('.', '_')->snake()->toString();

    // Error state
    $hasErrors = $errors->has($field);

    // Icon mapping
    $icon = match ($type) {
        'address' => 'tabler:map-pin-filled',
        'business', 'company' => 'ion:business',
        'date', 'time' => 'mdi:calendar-time',
        'datetime', 'event', 'year' => 'ic:round-event-note',
        'email' => 'eva:email-fill',
        'image' => 'mdi:image',
        'link', 'url' => 'material-symbols:link',
        'password' => 'tabler:lock-filled',
        'tel', 'telp', 'phone' => 'solar:phone-bold',
        'text', 'textarea' => 'ion:text',
        'user', 'person', 'name', 'username' => 'ion:person',
        default => $icon ?? 'ion:text',
    };

    // Normalisasi type input
    $type = match ($type) {
        'year' => 'number',
        'phone', 'telp' => 'tel',
        default => $type,
    };

    $style = [
        'base' => css('relative flex items-center w-full'),
        'input' => css('input glass w-full rounded-xl !border pl-8', [
            '!border-red-500 focus:ring-2 focus:ring-red-500 focus:outline-none' => $hasErrors,
            'focus:ring-1 focus:ring-neutral-200 focus:outline-none' => !$hasErrors,
            'disabled:border-neutral-500 disabled:bg-neutral-200 disabled:text-neutral-400' => $disabled,
            'min-h-24 p-2 text-wrap' => $type === 'textarea' || $type === 'address',
        ]),
        'icon' => [
            'textarea' => css(
                'z-2 absolute left-3 top-5 -translate-y-1/2 transform text-center text-sm text-neutral-400',
            ),
            'input' => css(
                'z-2 absolute left-3 top-1/2 -translate-y-1/2 transform text-center text-sm text-neutral-400',
            ),
        ],
    ];

    $class = css($class, $style['base']);
@endphp

<div class="{{ $class }}" x-data="{ value: @entangle($field) }">
    @if ($type === 'textarea' || $type === 'address')
        <textarea
            {{ $attributes->merge([
                'aria-invalid' => $hasErrors ? 'true' : 'false',
                'autocomlete' => $name,
                'autofocus' => $autofocus || $hasErrors,
                'class' => $style['input'] ?? '',
                'disabled' => $disabled,
                'id' => $name,
                'name' => $name,
                'placeholder' => $placeholder,
                'required' => $required,
                'type' => $type,
            ]) }}
            x-model.debounce.500ms="value"></textarea>

        <iconify-icon class="{{ $style['icon']['textarea'] }}" icon="{{ $icon }}"></iconify-icon>
    @else
        <input
            {{ $attributes->merge([
                'aria-invalid' => $hasErrors ? 'true' : 'false',
                'autocomlete' => $name,
                'autofocus' => $autofocus || $hasErrors,
                'class' => $style['input'] ?? '',
                'disabled' => $disabled,
                'id' => $name,
                'name' => $name,
                'placeholder' => $placeholder,
                'required' => $required,
                'type' => $type,
            ]) }}
            x-model.debounce.500ms="value" />

        <iconify-icon class="{{ $style['icon']['input'] }}" icon="{{ $icon }}"></iconify-icon>
    @endif
</div>
