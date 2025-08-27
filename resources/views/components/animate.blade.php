@props([
    'type' => 'fade-in',
])

@if ($type === 'fade-in-out')
    <x-animate.fade-in-out {{ $attributes }}>
        {{ $slot }}
    </x-animate.fade-in-out>
@elseif ($type === 'fade-out')
    <x-animate.fade-out {{ $attributes }}>
        {{ $slot }}
    </x-animate.fade-out>
@else
    <x-animate.fade-in {{ $attributes }}>
        {{ $slot }}
    </x-animate.fade-in>
@endif
