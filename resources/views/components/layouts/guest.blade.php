@extends('components.layouts.layout')

@section('content')
    <x-ui.bg-decoration />

    <header class="w-full">
        <x-ui.navbar fixed />
    </header>

    <main class="wh-full container mx-auto flex min-h-screen flex-col p-4 md:p-8 lg:p-12">
        {{ $slot }}
    </main>
@endsection
