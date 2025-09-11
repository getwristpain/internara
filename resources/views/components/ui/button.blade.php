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
    'target' => '',
])

@php
    $color = match (true) {
        empty($color) && $type === 'submit' => 'primary',
        empty($color) && $type === 'link' => 'link',
        default => $color,
    };

    $icon = match (true) {
        empty($icon) && $color === 'primary' => 'uni-arrow-circle-right-o',
        $icon === 'hidden' => null,
        default => $icon,
    };

    $style = [
        'button' => [
            'base' =>
                'btn rounded-xl items-center gap-4 transition duration-150 ease-in-out text-nowrap flex-nowrap active:scale-95',
            'shadow' => $shadowed ? 'shadow-lg shadow-neutral-400' : '',
            'color' => match ($color) {
                'primary'
                    => 'btn-neutral btn-outline bg-gradient-to-b from-neutral-700 to-neutral-950 text-neutral-100 hover:from-neutral-950',
                'secondary'
                    => 'btn-neutral btn-outline border-neutral-500 text-neutral-700 bg-gradient-to-b from-neutral-100 to-neutral-300 hover:from-neutral-300',
                'error'
                    => 'btn-error btn-outline border-red-500 text-red-700 bg-gradient-to-b from-red-100 to-red-300 hover:from-red-300',
                'link' => 'btn-ghost',
                default => '',
            },
        ],
        'icon' => '',
    ];

    $class = trim($class . ' ' . implode(' ', array_values($style['button'])));
@endphp

@if ($type === 'link')
    <a class="{{ $class }}" role="button" href="{{ route($action ?? '') ?? '#' }}" tabindex="0" wire:navigate
        {{ $attributes }}>
        @isset($label)
            <span class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset

        @isset($icon)
            <x-ui.icon class="{{ $style['icon'] }}" icon="{{ $icon }}" />
        @endisset
    </a>
@elseif ($type === 'submit')
    <button class="{{ $class }}" type="submit" form="{{ $form }}" title="{{ $title }}"
        {{ $attributes }}>
        <span class="loading loading-spinner hidden" wire:target="{{ $target }}"
            wire:loading.class="block"></span>

        @isset($label)
            <span class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset

        @isset($icon)
            <x-ui.icon class="{{ $style['icon'] }}" icon="{{ $icon }}" />
        @endisset
    </button>
@else
    <button class="{{ $class }}" type="{{ $type }}" wire:click="{{ $action }}"
        title="{{ $title }}" {{ $attributes }}>
        @isset($label)
            <span class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset

        @isset($icon)
            <x-ui.icon class="{{ $style['icon'] }}" icon="{{ $icon }}" />
        @endisset
    </button>
@endif
