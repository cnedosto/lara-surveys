<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateSurvey extends Component
{
    public $name = "";
    public $questions = [];

    public function mount()
    {
        $this->questions[] = ['question_text' => ''];
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'questions.*.question_text' => 'required|string|max:255',
        ];
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();
        if ($user->role !== 'admin') {
            return;
        }

        $survey = Survey::create([
            'tenant_id' => $user->tenant_id,
            'name' => $this->name,
        ]);

        foreach ($this->questions as $question) {
            $survey->questions()->create([
                'question_text' => $question['question_text'],
            ]);
        }


        $this->dispatch('surveyAdded');
        $this->reset(['name', 'questions']);
        $this->dispatch('close-modal');
    }

    public function addQuestion()
    {
        $this->questions[] = ['question_text' => ''];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function render()
    {
        return view('livewire.create-survey');
    }
}
