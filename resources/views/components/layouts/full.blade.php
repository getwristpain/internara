@extends('components.layouts.layout')

@section('content')
    <x-bg-decoration />
    <x-navbar home_url="#" fixed />

    <main class="wh-full container mx-auto flex min-h-screen flex-col p-4 md:p-8">
        {{ $slot }}
    </main>
@endsection
