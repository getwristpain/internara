@props([
    'url' => '#',
    'type' => '',
    'label' => '',
])

@php
    $style = css('transition ease-in-out duration-150 hover:underline', [
        'btn border-none hover:bg-transparent' => $type === 'button',
    ]);
@endphp

<a x-data :class="@js($style)" href="{{ $url }}" wire:navigate {{ $attributes }}>
    {{ $label ?? $slot }}
</a>
