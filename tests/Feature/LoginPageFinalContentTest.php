<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginPageFinalContentTest extends TestCase
{
    /**
     * Test required developer identity content and absence of prohibited strings.
     */
    public function test_login_page_renders_required_identity_and_branding(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        // Required text
        $response->assertSee('Employee Management & Analytics', false);
        $response->assertSee('Developed by');
        $response->assertSee('Dea Kusuma Ningrum');
        $response->assertSee('23082010048');

        // Prohibited text check
        $response->assertDontSee('Peserta Uji Kompetensi');
        $response->assertDontSee('Peserta');
        $response->assertDontSee('Participant');
    }

    /**
     * Test that essential interactive controls and links are present and accessible.
     */
    public function test_login_page_interactive_controls_are_intact(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        // Form elements
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="remember"', false);
        $response->assertSee('type="submit"', false);
        $response->assertSee('Sign In');

        // Registration link
        $response->assertSee(route('register'), false);
        $response->assertSee('Create new account');

        // Demo credentials buttons
        $response->assertSee('admin@example.com');
        $response->assertSee('user@example.com');
    }

    /**
     * Test scrolling and layout structure for small screens and short viewports.
     */
    public function test_login_page_layout_classes_prevent_clipping_and_allow_scroll(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        // Body must allow vertical scrolling and prevent horizontal clipping
        $response->assertSee('overflow-y-auto', false);
        $response->assertSee('overflow-x-hidden', false);
        $response->assertSee('min-h-screen', false);

        // Grid must adapt on mobile and desktop
        $response->assertSee('grid grid-cols-1 lg:grid-cols-12', false);
    }
}
