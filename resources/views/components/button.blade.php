@props([
    'action' => '',
    'class' => '',
    'color' => null,
    'form' => null,
    'icon' => null,
    'label' => null,
    'shadowed' => false,
    'title' => '',
    'type' => 'button',
    'style' => [],
])

@php
    $type = in_array($type, ['button', 'submit', 'reset']) ? $type : 'button';
    $color = $type === 'submit' && empty($color) ? 'primary' : $color;

    $icon = match (true) {
        $color === 'primary' && empty($icon) => 'icon-park-solid:right-c',
        $icon === 'hidden' => null,
        default => $icon,
    };

    $style['button']['default'] =
        'btn rounded-xl items-center gap-4 transition duration-150 ease-in-out text-nowrap flex-nowrap active:scale-95';

    $style['button']['color'] = match ($color) {
        'primary'
            => 'btn-neutral btn-outline bg-gradient-to-b from-neutral-700 to-neutral-950 text-neutral-100 hover:from-neutral-950',
        'secondary'
            => 'btn-neutral btn-outline border-neutral-500 text-neutral-700 bg-gradient-to-b from-neutral-100 to-neutral-300 hover:from-neutral-300',
        'error'
            => 'btn-error btn-outline border-red-500 text-red-700 bg-gradient-to-b from-red-100 to-red-300 hover:from-red-300',
        default => '',
    };

    $style['button']['shadow'] = $shadowed
        ? 'shadow-lg shadow-neutral-400'
        : '';

    $class .= ' ' . implode(' ', array_values($style['button']));
@endphp

@if ($type === 'submit')
    <button class="{{ $class }}" type="submit" form="{{ $form }}"
        title="{{ $title }}" {{ $attributes }}>
        @isset($label)
            <span
                class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset

        @isset($icon)
            <iconify-icon class="{{ $style['icon'] ?? '' }}"
                icon="{{ $icon }}"></iconify-icon>
        @endisset
    </button>
@else
    <button class="{{ $class }}" type="{{ $type }}"
        wire:click="{{ $action }}" title="{{ $title }}"
        {{ $attributes }}>
        @isset($label)
            <span
                class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset

        @isset($icon)
            <iconify-icon class="{{ $style['icon'] ?? '' }}"
                icon="{{ $icon }}"></iconify-icon>
        @endisset
    </button>
@endif
