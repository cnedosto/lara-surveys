<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;

class SurveyReports extends Component
{
    public $surveys;

    public function mount()
    {
        $this->loadSurveys();
    }

    public function loadSurveys()
    {
        $this->surveys = Survey::where('tenant_id', auth()->user()->tenant_id)
            ->withCount('questions')
            ->get();
    }

    protected $listeners = ['surveyUpdated' => 'loadSurveys'];

    public function render()
    {
        return view('livewire.survey-reports', [
            'surveys' => $this->surveys,
        ]);
    }
}
