@props([
    'name' => app(\App\Services\SystemService::class)->first()->name,
])

<a href="{{ url('/') }}" wire:navigate>
    <div class="flex items-center justify-center gap-2 text-lg font-bold">
        <span><x-logo class="max-w-4" /></span>
        <span>{{ $name }}</span>
    </div>
</a>
