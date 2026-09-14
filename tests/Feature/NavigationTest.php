<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $standardUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'name' => 'Dea Kusuma Ningrum',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->standardUser = User::factory()->create([
            'name' => 'John Staff',
            'email' => 'user@example.com',
            'role' => 'user',
        ]);
    }

    public function test_desktop_sidebar_renders_with_navigation_links(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Pegawai<span class="text-teal-400 font-extrabold">Hub</span>', false);
        $response->assertSee('Dashboard');
        $response->assertSee('Employees');
        $response->assertSee('Add Employee');
        $response->assertSee('Sign Out');
    }

    public function test_sidebar_has_collapsible_and_localstorage_persistence_attributes(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee("sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true'", false);
        $response->assertSee("localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed)", false);
        $response->assertSee('toggleSidebar()', false);
        $response->assertSee('sidebarOpen', false);
    }

    public function test_admin_sees_add_employee_navigation_item(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Add Employee');
        $response->assertSee('Admin');
    }

    public function test_standard_user_does_not_see_add_employee_navigation_item(): void
    {
        $response = $this->actingAs($this->standardUser)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Employees');
        $response->assertDontSee('Add Employee');
    }

    public function test_active_route_is_highlighted_for_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertStatus(200);
        // Dashboard should have active styling
        $response->assertSee('bg-teal-500/15 text-teal-300 border border-teal-500/30');
    }

    public function test_mobile_off_canvas_drawer_elements_exist(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertStatus(200);
        // Backdrop overlay
        $response->assertSee('sidebarOpen = false', false);
        // Hamburger trigger
        $response->assertSee('sidebarOpen = true', false);
        // Esc key listener
        $response->assertSee('@keydown.escape.window="sidebarOpen = false"', false);
    }

    public function test_desktop_sidebar_fixed_layout_and_independent_scroll_structure(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertStatus(200);
        // Aside has fixed viewport positioning and independent vertical scrolling
        $response->assertSee('fixed inset-y-0 left-0 z-50', false);
        $response->assertSee('overflow-y-auto overflow-x-hidden', false);
        // Content container dynamically adjusts left padding to avoid overlap
        $response->assertSee("'lg:pl-68': !sidebarCollapsed", false);
        $response->assertSee("'lg:pl-20': sidebarCollapsed", false);
        // Body prevents horizontal overflow
        $response->assertSee('overflow-x-hidden', false);
    }
}

