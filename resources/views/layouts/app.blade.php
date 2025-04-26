@php
    $systemService = new \App\Services\SystemService();
    $system = $systemService->first();
@endphp

<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="author" content="{{ $author ?? '' }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description ?? '' }}">
        <meta name="keywords" content="{{ $keywords ?? '' }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Title -->
        <title>{{ $title ?? $system->name }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ $favicon ?? asset($system->logo) }}" type="image/x-icon">

        <!-- Vite Configs -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles()
        @stack('head')
    </head>

    <body>
        @yield('body')

        @livewireScripts
        @stack('scripts')
    </body>

</html>
