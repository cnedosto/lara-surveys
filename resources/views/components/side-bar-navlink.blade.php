@props([
    'route',
])

<a href="{{route($route)}}" 
    class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold 
    {{Request::routeIs($route) ? 'bg-gray-800 text-white ' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}
">
    {{$slot}}
</a>