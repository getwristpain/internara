<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('partials.head')
    </head>

    <body class="max-w-screen min-h-screen overflow-x-hidden">
        {{-- Header --}}
        <x-header />

        {{-- Main Content --}}
        <flux:main container>
            {{ $slot }}
        </flux:main>

        @stack('scripts')
        @fluxScripts
    </body>

</html>
