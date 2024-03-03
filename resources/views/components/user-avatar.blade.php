@props([
    'name',
    'isSmall' => "false"
])

@php
    $nameParts = explode(' ', $name);
    $initials = '';

    $bgColors = [
        'bg-red-400',
        'bg-red-500',
        'bg-red-600',
        'bg-green-400',
        'bg-green-500',
        'bg-green-600',
        'bg-blue-400',
        'bg-blue-500',
        'bg-blue-600',
        'bg-yellow-400',
        'bg-yellow-500',
        'bg-yellow-600',
        'bg-indigo-400',
        'bg-indigo-500',
        'bg-indigo-600',
        'bg-pink-400',
        'bg-pink-500',
        'bg-pink-600',
        'bg-teal-400',
        'bg-teal-500',
        'bg-teal-600',
        'bg-emerald-400',
        'bg-emerald-500',
        'bg-emerald-600',
        'bg-lime-400',
        'bg-lime-500',
        'bg-lime-600',
    ];

    $randomBgColor = $bgColors[array_rand($bgColors)];

    if (count($nameParts) > 0) {
        $initials .= $nameParts[0][0];
    }

    if (count($nameParts) > 1) {
        $initials .= $nameParts[count($nameParts) - 1][0];
    }
@endphp

<div class="{{$isSmall == 'true' ? 'h-8 w-8' : 'h-12 w-12'}} rounded-full {{$randomBgColor}} flex items-center justify-center">
    <span class="{{$isSmall == 'true' ? 'text-sm' : 'text-xl'}}">{{ strtoupper($initials) }}</span>
</div>
