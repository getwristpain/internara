@props([
    'action' => '',
    'disabled' => false,
    'icon' => null,
    'iconEffect' => '',
    'reverse' => false,
    'hideLabel' => false,
])

<button x-data="{
    rotated: false,
    iconEffect: @js($iconEffect),
}" wire:click="{{ $action }}"
    @click="
        if (iconEffect === 'rotate') {
            rotated = !rotated;
        }
    "
    {{ $attributes->merge([
        'class' => implode(' ', ['btn', !$reverse ?: 'flex-row-reverse']),
        'disabled' => $disabled,
    ]) }}
    type="button">

    @isset($icon)
        <iconify-icon class="transition-transform duration-300" :class="{ 'rotate-180': rotated }"
            icon="{{ $icon }}"></iconify-icon>
    @endisset

    @if (!$hideLabel)
        <span>{{ $slot }}</span>
    @endif
</button>
