@extends("components.layouts.app")

@section("content")
    <x-bg-decoration />

    @include("components.partials.layouts.guest.navbar", [
        "fixed" => true,
    ])

    <main
        class="wh-full container mx-auto flex min-h-screen flex-col p-4 px-4 pt-24 md:px-8 lg:px-16">
        {{ $slot }}
    </main>
@endsection
