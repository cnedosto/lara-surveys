<?php

namespace App\Livewire\Auth;

use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $firstName = '';

    /** @var string */
    public $lastName = '';

    /** @var string */
    public $companyName = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public $role = 'admin';

    public function register()
    {
        $this->validate([
            'firstName' => ['required', 'string', 'min:3'],
            'lastName' => ['required', 'string', 'min:3'],
            'companyName' => ['required', 'string', 'unique:tenants,name'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'role' => ['required'],
        ]);

        $tenant = Tenant::create([
            'name' => $this->companyName,
        ]);

        $fullName = $this->firstName . ' ' . $this->lastName;

        $user = User::create([
            'email' => $this->email,
            'name' => $fullName,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'tenant_id' => $tenant->id,
        ]);


        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function updated($value)
    {
        $this->resetErrorBag($value);
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
