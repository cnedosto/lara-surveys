<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Survey;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
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

        $response = $this->actingAs($admin)->postJson(route('surveys'), [
            'tenant_id' => $tenant->id,
            'name' => 'Customer Feedback',
            'questions' => [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ],
        ]);

        $response->assertStatus(201);

        $survey = Survey::first();

        $this->assertEquals($tenant->id, $survey->tenant_id);
        $this->assertEquals('Customer Feedback', $survey->name);
        $this->assertCount(2, $survey->questions);
    }

    public function test_non_admin_cannot_create_survey()
    {
        $user = User::factory()->create(['role' => 'member']);
        $response = $this->actingAs($user)->postJson(route('surveys'), [
            'name' => 'Customer Feedback',
            'questions' => [
                ['question_text' => 'How do you rate our service?'],
            ],
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_from_tenant1_cannot_create_survey_in_tenant2()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();
        $adminUserTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);

        auth()->login($adminUserTenant1);

        $surveyData = [
            'tenant_id' => $tenant2->id,
            'name' => 'Unauthorized Survey',
            'questions' => [
                ['question_text' => 'This should not be allowed.'],
            ],
        ];

        $response = $this->postJson(route('surveys.store'), $surveyData);

        $response->assertStatus(403);
    }

    public function test_user_should_be_able_to_see_surveys()
    {
        $tenant1 = Tenant::factory()->create();
        $adminTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);

        $response = $this->actingAs($adminTenant1)->postJson(route('surveys'), [
            'tenant_id' => $tenant1->id,
            'name' => 'Customer Feedback',
            'questions' => [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant1->id,
        ]);

        $userTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'member',
        ]);

        $response = $this->actingAs($userTenant1)->json('GET', '/surveys/list');
        $response->assertOk();
        $jsonResponse = $response->json();

        $containsCustomerFeedback = collect($jsonResponse)->contains(function ($item) {
            return $item['name'] === 'Customer Feedback';
        });

        $this->assertTrue($containsCustomerFeedback);
    }

    public function test_user_from_tenant2_cannot_see_surveys_from_tenant1()
    {
        $tenant1 = Tenant::factory()->create();
        $adminTenant1 = User::factory()->create([
            'tenant_id' => $tenant1->id,
            'role' => 'admin',
        ]);

        $response = $this->actingAs($adminTenant1)->postJson(route('surveys'), [
            'tenant_id' => $tenant1->id,
            'name' => 'Customer Feedback',
            'questions' => [
                ['question_text' => 'How do you rate our service?'],
                ['question_text' => 'Any suggestions for improvement?'],
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('surveys', [
            'name' => 'Customer Feedback',
            'tenant_id' => $tenant1->id,
        ]);

        $tenant2 = Tenant::factory()->create();
        $userTenant2 = User::factory()->create([
            'tenant_id' => $tenant2->id,
            'role' => 'member',
        ]);

        $response = $this->actingAs($userTenant2)->json('GET', '/surveys/list');

        $response->assertOk();
        $jsonResponse = $response->json();
        $containsCustomerFeedback = collect($jsonResponse)->contains(function ($item) {
            return $item['name'] === 'Customer Feedback';
        });

        $this->assertFalse($containsCustomerFeedback);
    }
}
