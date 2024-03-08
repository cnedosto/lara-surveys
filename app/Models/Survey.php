<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    protected $fillable = ['tenant_id', 'name'];

    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function participants()
    {
        return $this->questions()
            ->join('user_answers', 'survey_questions.id', '=', 'user_answers.question_id')
            ->select('user_answers.user_id')
            ->distinct()
            ->count('user_answers.user_id');
    }

    public function status()
    {
        $totalUsers = User::where('tenant_id', $this->tenant_id)->count();

        $answeredUsers = $this->participants();

        return $answeredUsers >= $totalUsers ? 'answered' : 'ongoing';
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
    }
}
