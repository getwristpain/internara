@props([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'url' => asset(app(\App\Services\SystemService::class)->first()->logo),
    'alt' => 'Logo',
])

<div {{ $attributes->merge(['class' => 'w-full scale-125 avatar aspect-square']) }}>
    <!-- Logo Images -->
    <img class="object-cover object-center aspect-square" src="{{ $url }}" alt="{{ $alt }}"
        title="{{ $url }}">
</div>
