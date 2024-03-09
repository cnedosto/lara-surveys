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
    <td class="whitespace-nowrap px-3 py-4 text-sm">
        <span class="capitalize inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-inset ring-1
            {{$user->status ? 'bg-green-500/10 text-green-400 ring-green-500/20':'bg-red-400/10 text-red-400 ring-red-400/30' }}">
        {{ $user->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <div @click="$dispatch('editUser', { userId: {{$user->id}} }); openEditUserModal = true" class="text-indigo-400 hover:text-indigo-300 cursor-pointer">Edit</div>
    </td>
    </tr>
    @endforeach
</tbody>