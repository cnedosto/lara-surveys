<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class TeamMembers extends Component
{
    protected $listeners = ['userAdded' => 'render', 'userEdited' => 'render'];

    public function render()
    {
        return view('livewire.team-members', [
            'users' => User::all()
        ]);
    }
}
