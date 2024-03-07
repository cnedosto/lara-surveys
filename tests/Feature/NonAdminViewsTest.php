<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class NonAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_redirected_to_surveys_on_home_when_trying_dashboard()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertRedirect(route('surveys'));
    }

    public function test_non_admin_redirected_to_surveys_on_home_when_trying_team()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get(route('team'));

        $response->assertRedirect(route('surveys'));
    }

    public function test_non_admin_redirected_to_surveys_on_home_when_trying_reports()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);

        $response = $this->actingAs($user)->get(route('reports'));

        $response->assertRedirect(route('surveys'));
    }
}
