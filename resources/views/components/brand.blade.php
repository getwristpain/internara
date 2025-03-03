@props([
    'name' => app(\App\Services\SystemService::class)->first()->name,
])

<a href="{{ url('/') }}" wire:navigate>
    <div class="flex items-center gap-2 text-lg font-bold hover:bg-inherit basic-transition">
        <span><x-logo /></span>
        <span>{{ $name }}</span>
    </div>
</a>
