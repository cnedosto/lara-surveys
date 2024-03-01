@section('title', 'Create a new account')

<div>
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <a href="/">
                        <img class="h-8 w-auto" src="{{ asset('/images/lara-surveys.png') }}" alt="Lara Surveys">
                    </a>
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Start a 14 day free trial</h2>
                </div>

                <div class="mt-10">
                    <div>
                        <form wire:submit.prevent="register" class="space-y-6">
                            <div class="flex gap-x-4">
                                <x-form-input wire:model="firstName" type="text" inputName="firstName" label="First name" :required="true" />
                                <x-form-input wire:model="lastName" type="text" inputName="lastName" label="Last name" :required="true" />
                            </div>
                            <div>
                                <x-form-input wire:model="companyName" type="text" inputName="companyName" label="Company name" :required="true" />
                            </div>
                            <div>
                                <x-form-input wire:model="email" type="email" inputName="email" label="Email address" :required="true" />
                            </div>

                            <div>
                                <x-form-input wire:model="password" type="password" inputName="password" label="Password" :required="true" />
                            </div>

                            <div>
                                <x-form-input wire:model="passwordConfirmation" type="password" inputName="passwordConfirmation" label="Password confirmation" :required="true" />
                            </div>
                            <div>
                                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
        </div>
    </div>

</div>