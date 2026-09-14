<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($this->admin);
    }
    public function test_can_view_employee_index(): void
    {
        $response = $this->get('/employees');
        $response->assertStatus(200);
        $response->assertSee('Employee Records');
    }

    public function test_root_redirects_to_dashboard(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/dashboard');
    }

    public function test_can_filter_employees_by_gender(): void
    {
        $response = $this->get('/employees?gender=Laki-laki');
        $response->assertStatus(200);
        $response->assertSee('Laki-laki');
    }

    public function test_can_view_create_page(): void
    {
        $response = $this->get('/employees/create');
        $response->assertStatus(200);
        $response->assertSee('Employee Registration Form');
    }

    public function test_can_store_new_employee(): void
    {
        $data = [
            'name' => 'Testing Candidate',
            'gender' => 'Perempuan',
            'education' => 'S1',
            'age' => 26,
            'work_duration' => 3,
            'phone' => '081299998888',
            'email' => 'candidate.test@example.com',
        ];

        $response = $this->post('/employees', $data);

        $response->assertRedirect('/employees');
        $response->assertSessionHas('success', 'Employee added successfully.');

        $this->assertDatabaseHas('employees', [
            'email' => 'candidate.test@example.com',
            'phone' => '081299998888',
        ]);
    }

    public function test_store_validation_fails_with_invalid_inputs(): void
    {
        // 1. Missing required fields
        $response = $this->post('/employees', []);
        $response->assertSessionHasErrors(['name', 'gender', 'education', 'age', 'work_duration', 'phone', 'email']);

        // 2. Invalid age (< 18) and invalid email
        $response = $this->post('/employees', [
            'name' => 'John Doe',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 12,
            'work_duration' => 1,
            'phone' => '0812345678',
            'email' => 'not-an-email',
        ]);
        $response->assertSessionHasErrors(['age', 'email']);
    }

    private function createSampleEmployee(): Employee
    {
        return Employee::create([
            'name' => 'Sample Employee',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 28,
            'work_duration' => 3,
            'phone' => '08123456789',
            'email' => 'sample.' . uniqid() . '@example.com',
        ]);
    }

    public function test_can_view_employee_details(): void
    {
        $employee = $this->createSampleEmployee();

        $response = $this->get("/employees/{$employee->id}");
        $response->assertStatus(200);
        $response->assertSee($employee->name);
        $response->assertSee($employee->email);
    }

    public function test_can_view_edit_page(): void
    {
        $employee = $this->createSampleEmployee();

        $response = $this->get("/employees/{$employee->id}/edit");
        $response->assertStatus(200);
        $response->assertSee($employee->name);
    }

    public function test_can_update_employee(): void
    {
        $employee = $this->createSampleEmployee();

        $response = $this->put("/employees/{$employee->id}", [
            'name' => 'Updated Name',
            'gender' => $employee->gender,
            'education' => 'S2',
            'age' => $employee->age,
            'work_duration' => $employee->work_duration + 1,
            'phone' => $employee->phone,
            'email' => $employee->email,
        ]);

        $response->assertRedirect('/employees');
        $response->assertSessionHas('success', 'Employee updated successfully.');

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Name',
            'education' => 'S2',
        ]);
    }

    public function test_can_delete_employee(): void
    {
        $employee = Employee::create([
            'name' => 'To Be Deleted',
            'gender' => 'Laki-laki',
            'education' => 'D3',
            'age' => 30,
            'work_duration' => 5,
            'phone' => '08123450000',
            'email' => 'delete.me@example.com',
        ]);

        $response = $this->delete("/employees/{$employee->id}");

        $response->assertRedirect('/employees');
        $response->assertSessionHas('success', 'Employee deleted successfully.');

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }
}
