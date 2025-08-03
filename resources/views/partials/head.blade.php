@props([
    $title => config('app.name'),
    $favicon => asset(config('app.logo')),
])

<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? '' }}</title>
<link rel="shortcut icon" href="{{ $favicon ?? '' }}" type="image/x-icon">

@vite(['resources/css/app.css', 'resources/js/app.js'])

@stack('head')
