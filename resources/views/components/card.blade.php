@props([
    'bordered' => false,
    'class' => null,
    'shadowed' => false,
    'title' => null,
    'desc' => null,
])

@php
    $borderClass = $bordered ? '!border !border-neutral-900' : '';
    $shadowClass = $shadowed ? 'shadow-xl shadow-neutral-200' : '';
    $cardClass = 'card rounded-xl p-8 space-y-8';

    $class = implode(' ', array_values(array_filter([$cardClass, $borderClass, $shadowClass, $class])));
@endphp

<div class="{{ $class }}">
    @if (!empty($title) || !empty($desc))
        <div class="w-full">
            @isset($title)
                <span class="block w-full font-bold text-lg text-neutral-900">{{ $title }}</span>
            @endisset

            @isset($desc)
                <span class="block w-full text-neutral-600">{{ $desc }}</span>
            @endisset
        </div>
    @endif

    <div class="w-full">
        {{ $content ?? $slot }}
    </div>
</div>
