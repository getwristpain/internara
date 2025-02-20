@props([
    'APP_NAME' => config('app.name', 'Internara'),
    'APP_LOGO' => asset('images/logo.png'),
])

<a class="text-lg btn btn-ghost hover:bg-inherit basic-transition" href="{{ url('/') }}" wire:navigate>
    <span><x-logo url="{{ $APP_LOGO }}" /></span>
    <span>{{ $APP_NAME }}</span>
</a>
