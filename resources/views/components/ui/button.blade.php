@props([
    'class' => '',
    'label' => null,
    'type' => 'button',
    'color' => null,
    'icon' => null,
    'dirty' => null,
    'loading' => false,
    'shadowed' => false,
    'adapted' => false,
    'modify' => [],
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

    $modify = [
        'base' => css(
            'btn rounded-xl items-center gap-4 transition duration-150 ease-in-out text-nowrap flex-nowrap active:scale-95 disabled:disabled',
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
        'label' => css(['max-md:hidden' => $adapted && isset($label)]),
    ];

    $type = in_array($type, ['button', 'submit', 'reset']) ? $type : 'button';
    $class = css($modify['base'], $class);
@endphp

<button class="{{ $class }}" x-data="{ loading: @js($loading) }" x-cloak type="{{ $type }}" x-bind:disabled="loading"
    wire:loading.attr="disabled" {{ $attributes }}>
    {{-- Label --}}
    @isset($label)
        <span class="{{ $modify['label'] ?? 'truncate' }}">{{ $label }}</span>
    @endisset

    @if (isset($dirty))
        {{-- Icon --}}
        @isset($icon)
            <x-ui.icon class="icon-md" wire:target="{{ $dirty }}" wire:loading.class="hidden"
                icon="{{ $icon }}" />
        @endisset

        {{-- Loading Spinner --}}
        <span class="loading loading-spinner hidden" wire:target="{{ $dirty }}"
            wire:loading.class.remove="hidden"></span>
    @else
        @isset($icon)
            {{-- Icon --}}
            <x-ui.icon class="icon-md" x-show="!loading" icon="{{ $icon }}" />

            {{-- Loading Spinner --}}
            <span class="loading loading-spinner" x-show="loading"></span>
        @endisset
    @endif
</button>
