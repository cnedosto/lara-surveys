<div>
    <h2 class="text-4xl font-sembibold leading-9 mb-6 text-center">Edit team member</h2>
    <form wire:submit.prevent="submit; openEditUserModal = false" >
        <div>
            <p class="block text-sm font-medium leading-5 text-grey-600">Name :</p>
            <span>{{ $name }}</span>
        </div>
        <div class="my-4">
            <p class="block text-sm font-medium leading-5 text-grey-600">Email :</p>
            <span>{{ $email }}</span>
        </div>
        <div class="col-span-6 sm:col-span-2 mt-2">
            <label for="role" class="block text-sm font-medium leading-5 text-grey-600">Role</label>
            <select wire:model="role"
                    id="role"
                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="member">Team Member</option>
            </select>
            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <label for="status" class="mt-4 block text-sm font-medium leading-5 text-grey-600">Active</label>
        <input id="status" type="checkbox" wire:model="status" class="ml-1">
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end mt-4">
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Edit Team Member
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>