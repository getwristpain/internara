@extends('components.layouts.app')

@section('content')
    <x-bg-decoration></x-bg-decoration>
    <x-navbar fixed shadowed></x-navbar>

    <main class="container mx-auto wh-full min-h-screen p-4 md:p-8 lg:p-12 flex flex-col">
        {{ $slot }}
    </main>
@endsection
