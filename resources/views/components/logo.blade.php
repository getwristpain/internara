@props([
    'url' => asset(app(\App\Services\SystemService::class)->first()->logo),
    'alt' => 'Logo',
])

<div {{ $attributes->merge(['class' => 'w-4 scale-125 avatar relative']) }}>
    <!-- Logo Images -->
    <img class="object-cover object-center transition-opacity duration-300 aspect-square" src="{{ $url }}"
        alt="{{ $alt }}">
</div>
