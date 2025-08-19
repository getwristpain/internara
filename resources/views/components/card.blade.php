@props([
    'bordered' => false,
    'class' => null,
    'shadowed' => false,
    'title' => null,
    'desc' => null,
])

@php
    $borderClass = $bordered ? '!border !border-gray-900' : '';
    $shadowClass = $shadowed ? 'shadow-xl shadow-gray-200' : '';
    $cardClass = 'card rounded-xl transition ease-in-out duration-300 gap-4';

    $class = implode(' ', array_values(array_filter([$cardClass, $borderClass, $shadowClass, $class])));
@endphp

<div class="{{ $class }}" {{ $attributes }}>
    @if (!empty($title) || !empty($desc))
        <div class="w-full">
            @isset($title)
                <span class="block w-full font-bold text-lg text-gray-900">{{ $title }}</span>
            @endisset

            @isset($desc)
                <span class="block w-full text-gray-600">{{ $desc }}</span>
            @endisset
        </div>
    @endif

    <div class="w-full">
        {{ $content ?? $slot }}
    </div>
</div>
