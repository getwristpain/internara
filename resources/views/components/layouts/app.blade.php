<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ $title ?? config('app.name', 'Internara') }}</title>
        <link rel="shortcut icon" href="{{ $favicon ?? asset(config('app.logo', 'images/logo.png')) }}"
            type="image/x-icon">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
            rel="stylesheet">

        {{-- Vite Assets Build --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
    </head>

    <body>
        <div class="wh-full">{{ $slot }}</div>

        @stack('script')
    </body>

</html>
