<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    protected $fillable = ['question_id', 'option_text'];

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }
}
