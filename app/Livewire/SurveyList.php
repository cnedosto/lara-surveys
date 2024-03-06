<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;
use Illuminate\Support\Facades\Log;

class SurveyList extends Component
{
    public $surveys;

    public function mount()
    {
        $this->surveys = Survey::where('tenant_id', auth()->user()->tenant_id)->get();
    }

    public function render()
    {
        return view('livewire.survey-list', [
            'surveys' => $this->surveys,
        ]);
    }
}
