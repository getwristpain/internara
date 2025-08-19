@props([
    'action' => '',
    'class' => '',
    'color' => null,
    'form' => null,
    'icon' => null,
    'iconClass' => '',
    'label' => null,
    'labelClass' => '',
    'shadowed' => false,
    'title' => '',
    'type' => 'button',
])

@php
    $type = in_array($type, ['button', 'submit', 'reset']) ? $type : 'button';
    $color = $type === 'submit' && empty($color) ? 'primary' : $color;

    $icon = match (true) {
        $color === 'primary' && empty($icon) => 'icon-park-solid:right-c',
        $icon === 'none' => '',
        default => $icon,
    };

    $colorClass = match ($color) {
        'primary' => 'btn-neutral',
        'secondary' => 'btn-secondary',
        default => 'btn-ghost',
    };

    $shadowClass = $shadowed ? 'shadow-lg shadow-gray-300' : '';
    $btnClass =
        'btn rounded-full items-center gap-4 transition duration-150 ease-in-out hover:scale-110 text-nowrap flex-nowrap';

    $class = implode(' ', array_values(array_filter([$btnClass, $colorClass, $shadowClass, $class])));
@endphp

<button class="{{ $class }}" type="{{ $type }}" wire:click="{{ $action }}" form="{{ $form }}"
    title="{{ $title }}">
    @isset($label)
        <span class="truncate {{ $labelClass }}">{{ $label }}</span>
    @endisset

    @isset($icon)
        <iconify-icon class="{{ $iconClass }}" icon="{{ $icon }}"></iconify-icon>
    @endisset
</button>
