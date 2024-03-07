<?php

namespace Tests\Feature;

use App\Livewire\CreateSurvey;
use App\Livewire\SurveyList;
use App\Models\User;
use App\Models\Survey;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Livewire\Livewire;
use Tests\TestCase;

class SurveyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_survey()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $this->assertDatabaseHas('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant->id,
        ]);

        $survey = Survey::where('name', 'Customer Feedback')->first();
        $this->assertCount(2, $survey->questions);
    }

    public function test_non_admin_cannot_create_survey()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member'
        ]);

        Livewire::actingAs($user)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
            ])
            ->call('submit');

        $this->assertDatabaseMissing('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant->id,
        ]);
    }

    public function test_admin_from_tenant1_cannot_create_survey_in_tenant2()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();
        $adminUserTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($adminUserTenant1)
            ->test(CreateSurvey::class)
            ->set('name', 'Unauthorized Survey')
            ->set('tenant_id', $tenant2->id)
            ->set('questions', [
                ['question_text' => 'This should not be allowed.'],
            ])
            ->call('submit');

        $this->assertDatabaseMissing('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant2->id,
        ]);
    }

    public function test_user_should_be_able_to_see_surveys()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);

        Livewire::actingAs($user)
            ->test(SurveyList::class)
            ->assertSee('Customer Feedback');
    }

    public function test_user_from_tenant2_cannot_see_surveys_from_tenant1()
    {
        $tenant1 = Tenant::factory()->create();
        $adminTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);

        Livewire::actingAs($adminTenant1)
            ->test(CreateSurvey::class)
            ->set('name', 'Customer Feedback')
            ->set('questions', [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ])
            ->call('submit');

        $tenant2 = Tenant::factory()->create();
        $userTenant2 = User::factory()->create([
            'tenant_id' => $tenant2->id,
            'role' => 'member',
        ]);

        Livewire::actingAs($userTenant2)
            ->test(SurveyList::class)
            ->assertDontSee('Customer Feedback');
    }
}
