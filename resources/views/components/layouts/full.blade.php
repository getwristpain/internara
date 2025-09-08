@extends('components.layouts.layout')

@section('content')
    <x-bg-decoration />

    @include('components.partials.layouts.guest.navbar', [
        'fixed' => true,
        'home_url' => '#',
    ])

    <main class="wh-full container mx-auto flex min-h-screen flex-col p-4">
        {{ $slot }}
    </main>
@endsection
