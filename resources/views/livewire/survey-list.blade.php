<tbody class="divide-y divide-gray-800">
    @foreach($surveys as $survey)
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">{{ $survey->name }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300"></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300"></td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300"></td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="#" class="text-indigo-400 hover:text-indigo-300">Edit<span class="sr-only"></span></a>
            @endif
            </td>
        </tr>
    @endforeach
</tbody>