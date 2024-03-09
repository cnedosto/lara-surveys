<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class UpdateSurvey extends Component
{
    public $surveyId;
    public $surveyName = '';
    public $questions = [];
    public $removedQuestionIds = [];

    #[On(('openSurvey'))]
    public function getQuestion($surveyId)
    {
        $this->loadSurvey($surveyId);
    }

    public function loadSurvey($surveyId)
    {
        $survey = Survey::with('questions')->findOrFail($surveyId);
        $this->surveyId = $surveyId;
        $this->surveyName = $survey->name;
        $this->questions = $survey->questions->map(function ($question) {
            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
            ];
        })->toArray();
    }

    public function updateSurvey()
    {
        if (auth()->user() && auth()->user()->role !== 'admin') {
            return;
        }

        $this->validate([
            'surveyName' => 'required|string|max:255',
            'questions.*.question_text' => 'required|string|max:255',
        ]);

        $survey = Survey::findOrFail($this->surveyId);
        $survey->update(['name' => $this->surveyName]);

        foreach ($this->questions as $questionData) {
            if (isset($questionData['id'])) {
                $survey->questions()->where('id', $questionData['id'])->update([
                    'question_text' => $questionData['question_text'],
                ]);
            } else {
                $survey->questions()->create(['question_text' => $questionData['question_text']]);
            }
        }

        if (!empty($this->removedQuestionIds)) {
            SurveyQuestion::destroy($this->removedQuestionIds);
        }

        $this->removedQuestionIds = [];
        $this->dispatch('surveyUpdated');
    }


    public function addQuestion()
    {
        $this->questions[] = ['question_text' => ''];
    }

    public function removeQuestion($index)
    {
        $questionId = $this->questions[$index]['id'] ?? null;
        if ($questionId) {
            $this->removedQuestionIds[] = $questionId;
        }

        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function deleteSurvey()
    {
        if (auth()->user() && auth()->user()->role !== 'admin') {
            return;
        }
        Survey::with('questions')->findOrFail($this->surveyId)->delete();

        $this->dispatch('surveyUpdated');
    }


    public function render()
    {
        return view('livewire.update-survey');
    }
}
