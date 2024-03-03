@extends('layouts.app')

@section('title', 'Create Team Member')

@section('content')

<div class="mt-6 px-4 py-5 sm:rounded-lg sm:p-6">
    <div class="md:grid md:grid-cols-1 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-3xl font-medium leading-6 text-white">Personal Information</h3>
            <p class="mt-4 pr-3 text-sm leading-5 text-gray-400">
                Create a new team member.
            </p>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2 w-1/3">
            <livewire:create-user />
        </div>
    </div>
</div>

@endsection