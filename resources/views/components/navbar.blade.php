@props([
    'attributes' => [],
])

<div {{ $attributes->merge(['class' => 'navbar px-8 z-10']) }}>
    <x-brand></x-brand>
</div>
