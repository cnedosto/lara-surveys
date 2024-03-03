<div>
    <h2 class="text-4xl font-sembibold leading-9 mb-6 text-center">Create a new user</h2>
    <form wire:submit.prevent="submit" >
        <x-form-input
            wire:model="firstName"
            label="First name"
            :required="true"
            class="col-span-6 sm:col-span-3 mt-2"/>

        <x-form-input
            wire:model="lastName"
            label="Last name"
            :required="true"
            class="col-span-6 sm:col-span-3 mt-2"/>

        <x-form-input
            wire:model="email"
            type="email"
            label="Email"
            :required="true"
            class="col-span-6 sm:col-span-3 mt-2"/>

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
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end mt-4">
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Add Team Member
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>