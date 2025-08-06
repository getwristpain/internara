@props([
    'bordered' => false,
    'class' => null,
    'shadowed' => false,
    'title' => null,
])

@php
    $borderClass = $bordered ? '!border !border-neutral-900' : '';
    $shadowClass = $shadowed ? 'shadow-xl shadow-neutral-200' : '';
    $cardClass = 'card rounded-xl glass p-8 space-y-8';

    $class = implode(' ', array_values(array_filter([$cardClass, $borderClass, $shadowClass, $class])));
@endphp

<div class="{{ $class }}">
    @isset($title)
        <span class="block w-full font-bold text-lg text-neutral-900">{{ $title }}</span>
    @endisset

    <div>
        {{ $content ?? $slot }}
    </div>
</div>
