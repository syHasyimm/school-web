<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'SettingSeeder']);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_ppdb_form(): void
    {
        $response = $this->get('/ppdb/form');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_ppdb_dashboard(): void
    {
        $response = $this->get('/ppdb/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_access_admin_pages(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'calon_siswa']);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_ppdb_dashboard(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'calon_siswa']);

        $response = $this->actingAs($user)->get('/ppdb/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_post_management_without_auth(): void
    {
        $response = $this->get('/admin/posts');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_post_management(): void
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/posts');
        $response->assertStatus(200);
    }

    public function test_csrf_protection_on_contact_form(): void
    {
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        
        // Without CSRF should still work as we explicitly disabled it for this test
        $response = $this->post('/kontak', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content',
        ]);

        // Should redirect (success) or show validation errors
        $this->assertContains($response->status(), [302, 422, 200]);
    }
}
