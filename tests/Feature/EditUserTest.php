<?php

namespace Tests\Feature;

use App\Livewire\EditUser;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_set_a_user_inactive()
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
            ->test(EditUser::class)
            ->call('getUserInfo', $user->id)
            ->set('status', 0)
            ->call('submit');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 0]);
    }

    public function test_an_admin_can_set_a_user_active()
    {
        $tenant = Tenant::factory()->create();
        $admin = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'admin',
        ]);
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
            'status' => 0
        ]);

        Livewire::actingAs($admin)
            ->test(EditUser::class)
            ->call('getUserInfo', $user->id)
            ->set('status', 1)
            ->call('submit');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 1]);
    }

    public function test_an_admin_can_change_a_user_role()
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
            ->test(EditUser::class)
            ->call('getUserInfo', $user->id)
            ->set('role', 'admin')
            ->call('submit');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 'admin']);
    }

    public function test_a_member_cannot_set_a_user_inactive()
    {
        $tenant = Tenant::factory()->create();
        $user1 = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $user2 = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
            'status' => 1
        ]);

        Livewire::actingAs($user1)
            ->test(EditUser::class)
            ->call('getUserInfo', $user2->id)
            ->set('status', 0)
            ->call('submit');

        $this->assertDatabaseHas('users', ['id' => $user2->id, 'status' => 1]);
    }

    public function test_a_member_cannot_set_a_user_active()
    {
        $tenant = Tenant::factory()->create();
        $user1 = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $user2 = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
            'status' => 0
        ]);

        Livewire::actingAs($user1)
            ->test(EditUser::class)
            ->call('getUserInfo', $user2->id)
            ->set('status', 1)
            ->call('submit');

        $this->assertDatabaseHas('users', ['id' => $user2->id, 'status' => 0]);
    }

    public function test_a_member_cannot_change_a_user_role()
    {
        $tenant = Tenant::factory()->create();
        $user1 = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);
        $user2 = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role' => 'member',
        ]);

        Livewire::actingAs($user1)
            ->test(EditUser::class)
            ->call('getUserInfo', $user2->id)
            ->set('role', 'admin')
            ->call('submit');

        $this->assertDatabaseHas('users', ['id' => $user2->id, 'role' => 'member']);
    }
}
