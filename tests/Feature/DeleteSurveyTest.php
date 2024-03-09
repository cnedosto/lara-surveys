<?php

namespace Tests\Feature;

use App\Livewire\CreateSurvey;
use App\Livewire\UpdateSurvey;
use App\Models\Survey;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteSurveyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_a_survey()
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
            ->call('deleteSurvey');

        $this->assertDatabaseMissing('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant->id,
        ]);

        $this->assertDatabaseMissing('survey_questions', [
            'survey_id' => $survey->id,
            'question_text' => 'How do you rate our service?',
        ]);
    }

    public function test_member_cannot_delete_a_survey()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
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

        Livewire::actingAs($user)
            ->test(UpdateSurvey::class)
            ->call('loadSurvey', $survey->id)
            ->call('deleteSurvey');

        $this->assertDatabaseHas('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant->id,
        ]);

        $this->assertDatabaseHas('survey_questions', [
            'survey_id' => $survey->id,
            'question_text' => 'How do you rate our service?',
        ]);
    }
}
