@extends('components.layouts.app')

@section('content')
    <x-bg-decoration />

    <div class="wh-full flex min-h-screen gap-8">
        @include('components.partials.layouts.auth.sidebar')

        <main class="flex flex-1 flex-col gap-8">
            {{ $slot }}
        </main>
    </div>
@endsection
