<tbody class="divide-y divide-gray-800">
    @foreach ($users as $user)
    <tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-0 w-2/5">
        <div class="flex items-center">
        <div class="h-11 w-11 flex-shrink-0">
        <x-user-avatar name="{{$user->name}}" />
        </div>
        <div class="ml-4">
            <div class="font-medium text-white">{{ $user->name }}</div>
            <div class="mt-1 text-gray-500">{{ $user->email }}</div>
        </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300 capitalize">{{ $user->role}}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ $user->status ? 'Active' : 'Inactive' }}</td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <a href="#" class="text-indigo-400 hover:text-indigo-300">Edit</a>
    </td>
    </tr>
    @endforeach
</tbody>