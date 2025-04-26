@extends('layouts.app')

@section('body')
    <x-bg-decoration />

    <div class="flex flex-col wh-full">
        <div class="w-full">
            <x-navbar />
        </div>

        <main class="flex-1">
            @yield('content')
        </main>
    </div>
@endsection
