@props([
    'title' => null,
    'desc' => null,
    'class' => '',
    'bordered' => false,
    'shadowed' => false,
    'style' => [],
])

@php
    $style['card'] =
        'card rounded-xl transition ease-in-out duration-300 gap-4';
    $style['border'] = $borderClass = $bordered
        ? 'border border-neutral-900'
        : '';
    $style['shadow'] = $shadowed ? 'shadow-lg shadow-neutral-300' : '';

    $class .= ' ' . implode(' ', array_values($style));
@endphp

<div class="{{ $class }}" {{ $attributes }}>
    @if (!empty($title) || !empty($desc))
        <div class="w-full">
            @isset($title)
                <span
                    class="block w-full font-bold text-neutral-900">{{ $title }}</span>
            @endisset

            @isset($desc)
                <span
                    class="block w-full text-neutral-500">{{ $desc }}</span>
            @endisset
        </div>
    @endif

    <div class="w-full">
        {{ $content ?? $slot }}
    </div>
</div>
