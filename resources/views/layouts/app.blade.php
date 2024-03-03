@extends('layouts.base')

@section('body')

<div class="flex h-screen overflow-hidden bg-gray-900">
    <x-side-bar /> 
    <div class="grow">
        @yield('content')
        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
</div>
@endsection
