@props([
    'component' => [
        'buttonStyles' => 'btn btn-primary',
    ],
    'form' => null,
    'icon' => 'icon-park-outline:right-c',
    'hideIcon' => false,
    'reverse' => false,
])

<button type="submit"
    {{ $attributes->merge([
        'class' => implode(' ', [$component['buttonStyles'], !$reverse ?: 'flex-row-reverse']),
        'form' => $form,
    ]) }}>
    <span>{{ $slot }}</span>

    @if (isset($icon) && !$hideIcon)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endif
</button>
