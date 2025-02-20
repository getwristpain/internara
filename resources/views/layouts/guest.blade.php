<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ $title ?? config('app.name', 'Internara by Reas Vyn') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ $favicon ?? asset('images/logo.png') }}" type="image/x-icon">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <div class="flex flex-col wh-full">
            <x-navbar></x-navbar>

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </body>

</html>
