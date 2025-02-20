@props([
    'url' => asset('images/logo.png'),
    'alt' => 'Logo',
])

<div {{ $attributes->merge(['class' => 'avatar w-4 scale-125']) }}>
    <img class="aspect-square object-cover object-center" src="{{ $url }}" alt="{{ $alt }}">
</div>
