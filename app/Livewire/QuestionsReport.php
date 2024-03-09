<?php

namespace App\Livewire;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\UserAnswer;
use Livewire\Attributes\On;
use Livewire\Component;

class QuestionsReport extends Component
{
    public $submittedAnswers = [];
    public $questions = [];
    public $surveyName = '';

    #[On(('openSurveyReport'))]
    public function getQuestion($surveyId)
    {
        $this->questions = SurveyQuestion::where('survey_id', $surveyId)
            ->with(['answerOptions' => function ($query) {
                $query->withCount(['userAnswers as answers_count']);
            }])
            ->get();

        $usersCountPerQuestion = [];

        foreach ($this->questions as $question) {
            $usersCount = UserAnswer::where('question_id', $question->id)
                ->distinct('user_id')
                ->count('user_id');
            $usersCountPerQuestion[$question->id] = $usersCount;
        }

        foreach ($this->questions as &$question) {
            foreach ($question->answerOptions as &$option) {
                $totalUsers = $usersCountPerQuestion[$question->id] ?: 1;
                $option->rate = $option->answers_count / $totalUsers * 100;
            }
        }

        $this->surveyName = Survey::where('id', $surveyId)->value('name');
    }


    public function render()
    {
        return view('livewire.questions-report', [
            'questions' => $this->questions,
        ]);
    }
}
