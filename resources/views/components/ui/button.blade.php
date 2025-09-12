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
    $target = $target ?: $action;

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
        'base' => css(
            'btn rounded-xl items-center gap-4 transition duration-150 ease-in-out text-nowrap flex-nowrap active:scale-95',
            [
                'shadow-lg shadow-neutral-400' => $shadowed,
            ],
            match ($color) {
                'primary'
                    => 'btn-neutral btn-outline bg-gradient-to-b from-neutral-700 to-neutral-950 text-neutral-100 hover:from-neutral-950',
                'secondary'
                    => 'btn-neutral btn-outline border-neutral-500 text-neutral-700 bg-gradient-to-b from-neutral-100 to-neutral-300 hover:from-neutral-300',
                'error'
                    => 'btn-error btn-outline border-red-500 text-red-700 bg-gradient-to-b from-red-100 to-red-300 hover:from-red-300',
                'link' => 'btn-ghost',
                default => '',
            },
        ),
    ];

    $class = css($class, $style['base']);
@endphp

@if ($type === 'link')
    {{-- Button Link --}}
    <a class="{{ $class }}" role="button" href="{{ route($action ?? '') ?? '#' }}" tabindex="0" wire:navigate
        {{ $attributes }}>
        {{-- Label --}}
        @isset($label)
            <span class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset
        {{-- Icon --}}
        @isset($icon)
            <x-ui.icon class="{{ $style['icon'] ?? '' }}" icon="{{ $icon }}" />
        @endisset
    </a>
@elseif ($type === 'submit')
    {{-- Button Submit --}}
    <button class="{{ $class }}" type="submit" form="{{ $form }}" title="{{ $title }}"
        {{ $attributes }}>
        {{-- Label --}}
        @isset($label)
            <span class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset
        {{-- Icon --}}
        @isset($icon)
            <span wire:target="{{ $target }}" wire:loading.class="hidden">
                <x-ui.icon class="{{ $style['icon'] ?? '' }}" icon="{{ $icon }}" />
            </span>
        @endisset
        {{-- Loading Spinner --}}
        <span class="loading loading-spinner hidden" wire:target="{{ $target }}"
            wire:loading.class.remove="hidden"></span>
    </button>
@else
    {{-- General Button --}}
    <button class="{{ $class }}" type="{{ $type }}" wire:click="{{ $action }}"
        title="{{ $title }}" {{ $attributes }}>
        {{-- Label --}}
        @isset($label)
            <span class="{{ $style['label'] ?? '' }} truncate">{{ $label }}</span>
        @endisset
        {{-- Icon --}}
        @isset($icon)
            <span wire:target="{{ $target }}" wire:loading.class="hidden">
                <x-ui.icon class="{{ $style['icon'] ?? '' }}" icon="{{ $icon }}" />
            </span>
        @endisset
        {{-- Loading Spinner --}}
        <span class="loading loading-spinner hidden" wire:target="{{ $target }}"
            wire:loading.class.remove="hidden"></span>
    </button>
@endif
