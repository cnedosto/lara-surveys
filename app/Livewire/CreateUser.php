<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUser extends Component
{
    public $firstName = "";
    public $lastName = "";
    public $email = "";
    public $status = 1;
    public $role = "admin";
    public $password = "password";

    public function submit()
    {
        $validatedData = $this->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
        ]);

        $fullName = $this->firstName . ' ' . $this->lastName;

        User::create([
            'name' => $fullName,
            'email' => $this->email,
            'status' => $this->status,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        $this->dispatch('userAdded');

        $this->reset(['firstName', 'lastName', 'email', 'role']);

        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
