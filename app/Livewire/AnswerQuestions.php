<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;
use App\Models\UserAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class AnswerQuestions extends Component
{
    public $submittedAnswers = [];
    public $questions = [];
    public $surveyName = '';

    #[On(('openSurvey'))]
    public function getQuestion($surveyId)
    {
        $this->questions = SurveyQuestion::where('survey_id', $surveyId)->with('answerOptions')->get();
        $this->surveyName = Survey::where('id', $surveyId)->value('name');
    }

    public function submitAnswers()
    {
        foreach ($this->submittedAnswers as $questionId => $answerOptionId) {
            UserAnswer::updateOrCreate(
                [
                    'user_id' => auth()->user()->id,
                    'question_id' => $questionId,
                ],
                [
                    'answer_option_id' => $answerOptionId,
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.answer-questions', [
            'questions' => $this->questions,
        ]);
    }
}
