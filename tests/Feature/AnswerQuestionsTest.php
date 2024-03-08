<?php

namespace Tests\Feature;

use App\Models\{Survey, SurveyQuestion, User, Tenant, AnswerOption};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnswerQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function a_member_can_load_survey_questions()
    {
        $tenant = Tenant::factory()->create();
        $member = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $survey = Survey::factory()->create(['tenant_id' => $tenant->id]);
        SurveyQuestion::factory()->create(['survey_id' => $survey->id]);

        Livewire::actingAs($member)
            ->test('App\Http\Livewire\AnswerQuestions')
            ->call('getQuestion', $survey->id)
            ->assertViewHas('questions');
    }

    public function an_admin_can_load_survey_questions()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);
        $survey = Survey::factory()->create(['tenant_id' => $tenant->id]);
        SurveyQuestion::factory()->create(['survey_id' => $survey->id]);

        Livewire::actingAs($admin)
            ->test('App\Http\Livewire\AnswerQuestions')
            ->call('getQuestion', $survey->id)
            ->assertViewHas('questions');
    }

    public function a_user_can_submit_answers_to_questions()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member', // or 'admin', depending on your needs
        ]);
        $survey = Survey::factory()->create(['tenant_id' => $tenant->id]);
        $question = SurveyQuestion::factory()->create(['survey_id' => $survey->id]);
        $answerOption = AnswerOption::factory()->create(['survey_question_id' => $question->id]);

        Livewire::actingAs($user)
            ->test('App\Http\Livewire\AnswerQuestions')
            ->set('submittedAnswers', [$question->id => $answerOption->id])
            ->call('submitAnswers')
            ->assertHasNoErrors()
            ->assertDatabaseHas('user_answers', [
                'user_id' => $user->id,
                'question_id' => $question->id,
                'answer_option_id' => $answerOption->id,
            ]);
    }

    public function an_admin_can_submit_answers_to_questions()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admi ',
        ]);
        $survey = Survey::factory()->create(['tenant_id' => $tenant->id]);
        $question = SurveyQuestion::factory()->create(['survey_id' => $survey->id]);
        $answerOption = AnswerOption::factory()->create(['survey_question_id' => $question->id]);

        Livewire::actingAs($user)
            ->test('App\Http\Livewire\AnswerQuestions')
            ->set('submittedAnswers', [$question->id => $answerOption->id])
            ->call('submitAnswers')
            ->assertHasNoErrors()
            ->assertDatabaseHas('user_answers', [
                'user_id' => $user->id,
                'question_id' => $question->id,
                'answer_option_id' => $answerOption->id,
            ]);
    }
}
