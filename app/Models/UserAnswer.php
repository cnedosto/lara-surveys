<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{

    protected $fillable = ['user_id', 'question_id', 'answer_option_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class);
    }

    public function answerOption()
    {
        return $this->belongsTo(AnswerOption::class);
    }
}
