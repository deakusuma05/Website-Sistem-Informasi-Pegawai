<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_login_screen(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sign In to Your Account');
    }

    public function test_can_view_registration_screen(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register Account');
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'login.test@example.com',
            'password' => bcrypt('password123'),
            'role' => User::ROLE_USER,
        ]);

        $response = $this->post('/login', [
            'email' => 'login.test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/employees');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'login.test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'login.test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_new_user_can_register_as_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'Demo User',
            'email' => 'demo.user@example.com',
            'role' => 'user',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/employees');

        $this->assertDatabaseHas('users', [
            'email' => 'demo.user@example.com',
            'role' => 'user',
        ]);
    }

    public function test_new_user_can_register_as_admin(): void
    {
        $response = $this->post('/register', [
            'name' => 'Super Admin',
            'email' => 'super.admin@example.com',
            'role' => 'admin',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/employees');

        $this->assertDatabaseHas('users', [
            'email' => 'super.admin@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_login_fails_with_empty_fields(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_fails_with_invalid_email_format(): void
    {
        $response = $this->post('/login', [
            'email' => 'not-a-valid-email-format',
            'password' => 'somepassword123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_login_with_remember_me_sets_persistence_cookie(): void
    {
        $user = User::factory()->create([
            'email' => 'remember.user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'remember.user@example.com',
            'password' => 'password123',
            'remember' => '1',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertCookie(Auth::guard()->getRecallerName());
    }

    public function test_registration_fails_with_short_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Short Pass User',
            'email' => 'shortpass@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function test_registration_fails_with_unconfirmed_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Mismatch User',
            'email' => 'mismatch@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->post('/register', [
            'name' => 'Duplicate User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_registration_fails_with_invalid_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Invalid Email User',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}

