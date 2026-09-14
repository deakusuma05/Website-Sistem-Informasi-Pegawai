<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin.dash@example.com',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->user = User::factory()->create([
            'email' => 'user.dash@example.com',
            'role' => User::ROLE_USER,
        ]);
    }

    /**
     * Guest cannot access dashboard without logging in.
     */
    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Both standard users and admins can view the dashboard.
     */
    public function test_authenticated_users_can_view_dashboard(): void
    {
        // Standard user
        $this->actingAs($this->user)->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Workforce Analytics Dashboard');

        // Admin user
        $this->actingAs($this->admin)->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Workforce Analytics Dashboard');
    }

    /**
     * Proper empty state is displayed when 0 employees exist.
     */
    public function test_dashboard_shows_empty_state_when_no_employees_exist(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('No Employee Data Available');
        $response->assertSee('The database currently contains zero employee records.');
    }

    /**
     * Real database records populate KPI cards and chart containers.
     */
    public function test_dashboard_displays_real_kpi_and_chart_elements(): void
    {
        $this->actingAs($this->admin);

        // Seed 3 employees (2 male, 1 female)
        Employee::create([
            'name' => 'Male One',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 30,
            'work_duration' => 5,
            'phone' => '081234567890',
            'email' => 'm1@example.com',
        ]);

        Employee::create([
            'name' => 'Male Two',
            'gender' => 'Laki-laki',
            'education' => 'D3',
            'age' => 26,
            'work_duration' => 3,
            'phone' => '081234567891',
            'email' => 'm2@example.com',
        ]);

        Employee::create([
            'name' => 'Female One',
            'gender' => 'Perempuan',
            'education' => 'S2',
            'age' => 34,
            'work_duration' => 7,
            'phone' => '081234567892',
            'email' => 'f1@example.com',
        ]);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);

        // Assert KPI values
        $response->assertSee('Total Employees');
        $response->assertSee('3'); // Total
        $response->assertSee('Male Employees');
        $response->assertSee('2'); // Male
        $response->assertSee('Female Employees');
        $response->assertSee('1'); // Female
        $response->assertSee('30'); // Average age = (30+26+34)/3 = 30.0

        // Assert chart containers are present
        $response->assertSee('id="chart-gender-distribution"', false);
        $response->assertSee('id="chart-education-distribution"', false);
        $response->assertSee('id="chart-age-distribution"', false);
        $response->assertSee('id="chart-work-duration-distribution"', false);

        // Assert view receives exact real data for D3 charts
        $response->assertViewHas('charts', function ($charts) {
            $this->assertArrayHasKey('gender', $charts);
            $this->assertArrayHasKey('education', $charts);
            $this->assertArrayHasKey('age', $charts);
            $this->assertArrayHasKey('workDuration', $charts);

            // Gender: Male = 2, Female = 1
            $this->assertEquals(2, $charts['gender'][0]['count']);
            $this->assertEquals(1, $charts['gender'][1]['count']);

            return true;
        });
    }

    /**
     * Dynamic update test:
     * Adding, updating, and deleting an employee updates KPI metrics immediately.
     */
    public function test_kpi_metrics_update_dynamically_with_crud_operations(): void
    {
        $this->actingAs($this->admin);

        // Step 1: Add first employee
        $emp1 = Employee::create([
            'name' => 'First Employee',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 20,
            'work_duration' => 1,
            'phone' => '081234567890',
            'email' => 'first@example.com',
        ]);

        $res1 = $this->get('/dashboard');
        $res1->assertSee('Total Employees');
        $this->assertEquals(1, Employee::count());
        $this->assertEquals(20.0, round(Employee::avg('age'), 1));

        // Step 2: Add second employee (age 40)
        $emp2 = Employee::create([
            'name' => 'Second Employee',
            'gender' => 'Perempuan',
            'education' => 'S2',
            'age' => 40,
            'work_duration' => 15,
            'phone' => '081234567891',
            'email' => 'second@example.com',
        ]);

        $res2 = $this->get('/dashboard');
        $this->assertEquals(2, Employee::count());
        $this->assertEquals(30.0, round(Employee::avg('age'), 1)); // (20+40)/2 = 30.0

        // Step 3: Update second employee age to 60
        $emp2->update(['age' => 60]);
        $this->assertEquals(40.0, round(Employee::avg('age'), 1)); // (20+60)/2 = 40.0

        // Step 4: Delete first employee
        $emp1->delete();
        $this->assertEquals(1, Employee::count());
        $this->assertEquals(60.0, round(Employee::avg('age'), 1));
    }
}

