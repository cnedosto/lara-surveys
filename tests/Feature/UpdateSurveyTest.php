<?php

namespace Tests\Feature;

use App\Livewire\CreateSurvey;
use App\Livewire\UpdateSurvey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use App\Models\Tenant;
use Livewire\Livewire;

class UpdateSurveyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_question()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('tenant_id', $tenant->id)
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
            ])
            ->call('submit');

        $survey = Survey::latest()->first();

        Livewire::actingAs($admin)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->call('addQuestion')
            ->set('questions.1.question_text', 'Any suggestions for improvement?')
            ->call('updateSurvey');

        $this->assertDatabaseHas('survey_questions', [
            'survey_id' => $survey->id,
            'question_text' => 'Any suggestions for improvement?',
        ]);
    }

    public function test_admin_can_remove_question()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('tenant_id', $tenant->id)
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $survey = Survey::latest()->first();

        Livewire::actingAs($admin)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->call('removeQuestion', 1)
            ->call('updateSurvey');

        $this->assertDatabaseMissing('survey_questions', [
            'survey_id' => $survey->id,
            'question_text' => 'Any suggestions for improvement?',
        ]);
    }

    public function test_admin_can_change_survey_name()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('tenant_id', $tenant->id)
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $survey = Survey::latest()->first();

        Livewire::actingAs($admin)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->set('surveyName', 'Updated Survey Name')
            ->call('updateSurvey');

        $this->assertDatabaseHas('surveys', [
            'id' => $survey->id,
            'name' => 'Updated Survey Name',
        ]);
    }

    public function test_member_cannot_add_question()
    {
        $tenant = Tenant::factory()->create();
        $member = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('tenant_id', $tenant->id)
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $survey = Survey::latest()->first();

        Livewire::actingAs($member)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->call('addQuestion')
            ->set('questions.0.question_text', 'Member question attempt')
            ->call('updateSurvey');

        $this->assertDatabaseMissing('survey_questions', [
            'survey_id' => $survey->id,
            'question_text' => 'Member question attempt',
        ]);
    }

    public function test_member_cannot_remove_question()
    {
        $tenant = Tenant::factory()->create();
        $member = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('tenant_id', $tenant->id)
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $survey = Survey::latest()->first();

        Livewire::actingAs($member)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->call('removeQuestion', 1)
            ->call('updateSurvey');

        $this->assertDatabaseHas('survey_questions', [
            'survey_id' => $survey->id,
            'question_text' => 'Any suggestions for improvement?',
        ]);
    }

    public function test_member_cannot_change_survey_name()
    {
        $tenant = Tenant::factory()->create();
        $member = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('tenant_id', $tenant->id)
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $survey = Survey::latest()->first();

        Livewire::actingAs($member)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->set('surveyName', 'Updated Survey Name')
            ->call('updateSurvey');

        $this->assertDatabaseHas('surveys', [
            'id' => $survey->id,
            'name' => 'Customer Feedback',
        ]);
    }
}
