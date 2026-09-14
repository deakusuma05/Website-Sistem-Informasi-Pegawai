<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteConfirmationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($this->admin);
    }

    private function createEmployee(string $name = 'Jane Doe'): Employee
    {
        return Employee::create([
            'name' => $name,
            'gender' => 'Perempuan',
            'education' => 'S1',
            'age' => 29,
            'work_duration' => 4,
            'phone' => '081234567890',
            'email' => 'jane.' . uniqid() . '@example.com',
        ]);
    }

    /**
     * Test modal elements are present in the Blade templates.
     */
    public function test_delete_modal_markup_is_rendered(): void
    {
        $employee = $this->createEmployee('Rizky Ramadhan');

        $response = $this->get('/employees');
        $response->assertStatus(200);
        $response->assertSee('Delete Employee?');
        $response->assertSee('Are you sure you want to delete this employee? This action cannot be undone.');
        $response->assertSee('Cancel');
        $response->assertSee('Delete');
        $response->assertSee('openDeleteModal');
    }

    /**
     * Test Scenario 1: Cancel deletion
     * When user cancels or does not submit the DELETE request,
     * the employee remains intact in the database.
     */
    public function test_scenario_1_cancel_deletion_keeps_employee_in_database(): void
    {
        $employee = $this->createEmployee('Agus Setiawan');

        // Verify employee exists before interaction
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Agus Setiawan',
        ]);

        // User views index and triggers modal, but clicks Cancel (no DELETE dispatched)
        $response = $this->get('/employees');
        $response->assertStatus(200);

        // Employee MUST still exist in database
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Agus Setiawan',
        ]);

        // Details page still resolves with 200 OK
        $detailResponse = $this->get("/employees/{$employee->id}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Agus Setiawan');
    }

    /**
     * Test Scenario 2: Confirm deletion
     * When user clicks Delete in the confirmation modal,
     * the DELETE request is sent, employee is removed, and success feedback is returned.
     */
    public function test_scenario_2_confirm_deletion_removes_employee_with_feedback(): void
    {
        $employee = $this->createEmployee('Dewi Lestari');

        // Confirm deletion by sending DELETE request
        $response = $this->delete("/employees/{$employee->id}");

        // Asserts redirect to employee index
        $response->assertRedirect('/employees');

        // Asserts success feedback flash message
        $response->assertSessionHas('success', 'Employee deleted successfully.');

        // Asserts employee is removed from database
        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
            'name' => 'Dewi Lestari',
        ]);

        // Asserts employee cannot be retrieved (404)
        $this->get("/employees/{$employee->id}")->assertStatus(404);
    }
}
