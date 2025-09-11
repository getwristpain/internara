@props([
    'type' => 'fade-in',
])

@if ($type === 'fade-in-out')
    <x-ui.animate.fade-in-out {{ $attributes }}>
        {{ $slot }}
    </x-ui.animate.fade-in-out>
@elseif ($type === 'fade-out')
    <x-ui.animate.fade-out {{ $attributes }}>
        {{ $slot }}
    </x-ui.animate.fade-out>
@else
    <x-ui.animate.fade-in {{ $attributes }}>
        {{ $slot }}
    </x-ui.animate.fade-in>
@endif
