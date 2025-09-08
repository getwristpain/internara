@extends('components.layouts.layout')

@section('content')
    <x-bg-decoration />

    <div class="wh-full flex min-h-screen">
        @include('components.partials.layouts.auth.sidebar')

        <main class="wh-full flex flex-1 flex-col">
            {{ $slot }}
        </main>
    </div>
@endsection
