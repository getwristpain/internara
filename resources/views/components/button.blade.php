@props([
    'action' => '',
    'component' => [
        'buttonStyles' => 'btn',
    ],
    'disabled' => false,
    'icon' => null,
    'reverse' => false,
])

<button wire:click.prevent="{{ $action }}"
    {{ $attributes->merge([
        'class' => implode(' ', [$component['buttonStyles'], !$reverse ?: 'flex-row-reverse']),
        'disabled' => $disabled,
    ]) }}>

    @if (isset($icon))
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endif

    <span>{{ $slot }}</span>
</button>
