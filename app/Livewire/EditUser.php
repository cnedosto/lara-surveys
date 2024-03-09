<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class EditUser extends Component
{
    public $userId;
    public $name;
    public $email;
    public $role;
    public $status;

    #[On(('editUser'))]
    public function getUserInfo($userId)
    {
        $this->userId = $userId;
        $user = User::find($userId);

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->status = (bool) $user->status;
        }
    }

    public function submit()
    {
        if (auth()->user() && auth()->user()->role !== 'admin') {
            return;
        }

        $this->validate([
            'role' => 'required',
            'status' => 'required|boolean'
        ]);

        $user = User::find($this->userId);
        if ($user) {
            $user->update([
                'role' => $this->role,
                'status' => $this->status,
            ]);

            $this->dispatch('userEdited');
        }
    }

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.edit-user');
    }
}
