@props([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
])

<div {{ $attributes->merge([
    'class' => 'navbar bg-inherit bg-opacity-90 backdrop-blur-lg px-8 z-10',
]) }}>
    <x-brand></x-brand>
</div>
