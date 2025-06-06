@extends('layouts.app')

@section('body')
    <x-bg-decoration />

    <div class="flex flex-col wh-full">
        <header class="w-full">
            <x-navbar />
        </header>

        <main class="flex-1 w-full">
            @yield('main')
        </main>

        <footer class="flex items-center justify-center w-full min-h-40">
            <x-credit />
        </footer>
    </div>
@endsection
