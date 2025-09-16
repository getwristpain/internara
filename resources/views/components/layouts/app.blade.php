@extends('components.layouts.base')

@section('content')
    <x-bg-decoration />

    <div class="wh-full flex min-h-screen">
        <x-sidebar />

        <main class="wh-full flex flex-1 flex-col">
            {{ $slot }}
        </main>
    </div>
@endsection
