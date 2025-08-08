@props([
    'action' => '',
    'bordered' => false,
    'class' => null,
    'color' => 'default',
    'form' => '',
    'icon' => null,
    'label' => null,
    'shadowed' => false,
    'type' => 'button',
])

@php
    $type = in_array($type, ['button', 'submit', 'reset']) ? $type : 'button';
    $color = $type === 'submit' ? 'primary' : $color;
    $icon = $color === 'primary' ? 'icon-park-solid:right-c' : $icon;

    $colorClass = match ($color) {
        'primary' => 'btn-neutral',
        'secondary' => 'btn-secondary',
        default => 'btn-ghost',
    };

    $shadowClass = $shadowed ? 'shadow-xl shadow-neutral-200' : '';
    $btnClass = 'btn rounded-full items-center gap-4 transition duration-150 ease-in-out hover:scale-110 text-nowrap';

    $class = implode(' ', array_values(array_filter([$btnClass, $colorClass, $shadowClass, $class])));
@endphp

<button class="{{ $class }}" type="{{ $type }}" wire:click="{{ $action }}" form="{{ $form }}">
    <span>{{ $label ?? $slot }}</span>

    @isset($icon)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endisset
</button>
