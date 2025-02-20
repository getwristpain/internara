@props([
    'action' => '',
    'component' => [
        'buttonStyles' => 'btn',
    ],
    'disabled' => false,
    'icon' => '',
    'reverse' => false,
])

<button
    {{ $attributes->merge([
        'class' => implode(' ', [$component['buttonStyles'], !$reverse ?: 'flex-row-reverse']),
        'disabled' => $disabled,
    ]) }}>

    @if (isset($icon))
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
        <span>{{ $slot }}</span>
    @endif
</button>
