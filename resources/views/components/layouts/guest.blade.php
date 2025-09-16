@props([
    'home_url' => '/',
])

@extends('components.layouts.base')

@section('content')
    <x-ui.bg-decoration />
    <x-ui.notify x-data="{ show: false }" x-show="show" x-on:dirty-loading.window="show = $event.detail.loading" x-cloak
        type="info" message="Tunggu sebentar..." position="fixed-bl" pulse />

    <header class="w-full">
        <x-ui.navbar :$home_url fixed />
    </header>

    <main class="wh-full container mx-auto flex min-h-screen flex-col p-4 lg:p-8">
        {{ $slot }}
    </main>
@endsection
