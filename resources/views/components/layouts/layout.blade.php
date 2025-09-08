<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('components.partials.layouts.head')
    </head>

    <body class="min-wh-screen max-w-screen overflow-x-hidden font-sans text-neutral antialiased">
        @yield('content')
        @stack('scripts')
    </body>

</html>
