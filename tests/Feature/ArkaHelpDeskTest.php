<?php

namespace Tests\Feature;

use App\Models\AppInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArkaHelpDeskTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_unauthenticated_redirect_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_login_and_see_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@helpdesk.test',
            'role' => 'super_admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@helpdesk.test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_users_table_has_role_column(): void
    {
        $user = User::factory()->create();
        $this->assertEquals('user', $user->role);
    }

    public function test_apps_seed_works(): void
    {
        $this->seed();

        $this->assertDatabaseCount('apps', 5);
        $this->assertDatabaseHas('apps', ['name' => 'MineOps']);
    }

    public function test_admin_seeder_creates_users(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'admin@helpdesk.test', 'role' => 'super_admin']);
        $this->assertDatabaseHas('users', ['email' => 'iwan@helpdesk.test', 'role' => 'admin']);
    }

    public function test_ticket_can_be_created(): void
    {
        $app = AppInfo::factory()->create(['is_active' => true]);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post('/tickets', [
            'app_id' => $app->id,
            'subject' => 'Test tiket',
            'description' => 'Deskripsi tiket',
            'priority' => 'medium',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tickets', ['subject' => 'Test tiket']);
    }
}
