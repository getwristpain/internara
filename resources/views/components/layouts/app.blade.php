<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('partials.head')
    </head>

    <body>
        <div class="min-wh-screen">
            @yield('main')
        </div>

        @stack('scripts')
    </body>

</html>
