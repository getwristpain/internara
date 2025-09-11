@props([
    'attributes' => [],
    'type' => 'text',
    'field' => '',
    'icon' => 'ion:text',
    'placeholder' => '',
    'required' => false,
    'autofocus' => false,
    'disabled' => false,
    'hidden' => false,
    'style' => [],
])

@php
    // ID default fallback dari field
    $id = str($field)->replace('.', '_')->snake()->toString();

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
        'component' => [
            'container' => 'relative flex items-center',
        ],
        'input' => [
            'base' => 'input glass w-full rounded-xl !border pl-8',
            'state' => $hasErrors
                ? 'border-red-500 focus:ring-2 focus:ring-red-500 focus:outline-none'
                : 'focus:ring-1 focus:ring-neutral-200 focus:outline-none',
            'disabled' => 'disabled:border-neutral-500 disabled:bg-neutral-200 disabled:text-neutral-400',
        ],
        'icon' => [
            'textarea' => 'z-2 absolute left-3 top-5 -translate-y-1/2 transform text-center text-sm text-neutral-400',
            'input' => 'z-2 absolute left-3 top-1/2 -translate-y-1/2 transform text-center text-sm text-neutral-400',
        ],
    ];

    // Jika textarea, tambahkan tambahan style
    if ($type === 'textarea' || $type === 'address') {
        $style['input']['textarea'] = 'min-h-24 p-2 text-wrap';
    }

    // Kelas wrapper
    $componentClass = trim(implode(' ', array_values($style['component'])));

    // Gabungkan array ke string
    $inputClass = implode(' ', array_values($style['input']));

@endphp

<div class="{{ $componentClass }}">
    @if ($type === 'textarea' || $type === 'address')
        <textarea
            {{ $attributes->merge([
                'id' => $id,
                'class' => $inputClass,
                'name' => $id,
                'type' => $type,
                'placeholder' => $placeholder,
                'required' => $required,
                'disabled' => $disabled,
                'autocomlete' => $id,
                'autofocus' => $autofocus || $hasErrors,
                'aria-invalid' => $hasErrors ? 'true' : 'false',
            ]) }}
            wire:model="{{ $field }}"></textarea>

        <iconify-icon class="{{ $style['icon']['textarea'] }}" icon="{{ $icon }}"></iconify-icon>
    @else
        <input
            {{ $attributes->merge([
                'id' => $id,
                'class' => $inputClass,
                'name' => $id,
                'type' => $type,
                'placeholder' => $placeholder,
                'required' => $required,
                'disabled' => $disabled,
                'autocomlete' => $id,
                'autofocus' => $autofocus || $hasErrors,
                'aria-invalid' => $hasErrors ? 'true' : 'false',
            ]) }}
            wire:model="{{ $field }}" />

        <iconify-icon class="{{ $style['icon']['input'] }}" icon="{{ $icon }}"></iconify-icon>
    @endif
</div>
