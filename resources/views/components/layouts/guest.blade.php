@extends('components.layouts.app')

@section('main')
    <x-bg-decoration></x-bg-decoration>
    <x-navbar fixed shadowed></x-navbar>
    <main class="min-wh-screen">{{ $slot }}</main>
@endsection
