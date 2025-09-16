@props([
    'class' => 'items-center',
])

@extends('components.layouts.base')

@section('content')
    <x-ui.bg-decoration />

    <header class="w-full">
        <x-ui.navbar home_url="#" />
    </header>

    <main class="wh-full {{ $class }} container mx-auto flex min-h-screen flex-col p-4 md:p-8">
        {{ $slot }}
    </main>
@endsection
