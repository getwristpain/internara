@props([
    'title' => $shared->settings['brand_name'],
    'favicon' => asset($shared->settings['brand_logo']),
])

<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        {{-- Site Title --}}
        <title>{{ $title }}</title>

        {{-- Favicon --}}
        <link rel="preload" as="image" href="{{ asset($shared->settings['brand_logo']) }}" type="image/png">
        <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
            rel="stylesheet">

        {{-- Assets --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>

    <body class="min-wh-screen max-w-screen text-neutral overflow-x-hidden font-sans antialiased">
        @yield('content')
        @stack('scripts')
    </body>

</html>
