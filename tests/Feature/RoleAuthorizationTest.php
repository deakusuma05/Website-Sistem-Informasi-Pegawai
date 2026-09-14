<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $standardUser;
    private Employee $sampleEmployee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin.auth@example.com',
            'role' => User::ROLE_ADMIN,
        ]);

        $this->standardUser = User::factory()->create([
            'email' => 'standard.auth@example.com',
            'role' => User::ROLE_USER,
        ]);

        $this->sampleEmployee = Employee::create([
            'name' => 'Existing Employee',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 32,
            'work_duration' => 6,
            'phone' => '081234567890',
            'email' => 'existing.emp@example.com',
        ]);
    }

    /**
     * Unauthenticated guest cannot access protected employee directory.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/employees');
        $response->assertRedirect('/login');
    }

    /**
     * Standard User permissions: CAN view directory and individual details.
     */
    public function test_standard_user_can_view_directory_and_details(): void
    {
        $this->actingAs($this->standardUser);

        // Can view list
        $indexResponse = $this->get('/employees');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Existing Employee');

        // Can view detail
        $showResponse = $this->get("/employees/{$this->sampleEmployee->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Existing Employee');
    }

    /**
     * Standard User permissions: CANNOT access create form (403 Forbidden).
     */
    public function test_standard_user_cannot_access_create_form(): void
    {
        $this->actingAs($this->standardUser);

        $response = $this->get('/employees/create');
        $response->assertStatus(403);
    }

    /**
     * Standard User permissions: CANNOT submit new employee (403 Forbidden).
     */
    public function test_standard_user_cannot_store_employee(): void
    {
        $this->actingAs($this->standardUser);

        $response = $this->post('/employees', [
            'name' => 'Unauthorized Employee',
            'gender' => 'Laki-laki',
            'education' => 'D3',
            'age' => 25,
            'work_duration' => 2,
            'phone' => '08123456789',
            'email' => 'unauth@example.com',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('employees', ['email' => 'unauth@example.com']);
    }

    /**
     * Standard User permissions: CANNOT access edit form (403 Forbidden).
     */
    public function test_standard_user_cannot_access_edit_form(): void
    {
        $this->actingAs($this->standardUser);

        $response = $this->get("/employees/{$this->sampleEmployee->id}/edit");
        $response->assertStatus(403);
    }

    /**
     * Standard User permissions: CANNOT submit employee update (403 Forbidden).
     */
    public function test_standard_user_cannot_update_employee(): void
    {
        $this->actingAs($this->standardUser);

        $response = $this->put("/employees/{$this->sampleEmployee->id}", [
            'name' => 'Hacked Name',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 32,
            'work_duration' => 6,
            'phone' => '081234567890',
            'email' => 'existing.emp@example.com',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('employees', ['name' => 'Hacked Name']);
    }

    /**
     * Standard User permissions: CANNOT delete employee (403 Forbidden).
     */
    public function test_standard_user_cannot_delete_employee(): void
    {
        $this->actingAs($this->standardUser);

        $response = $this->delete("/employees/{$this->sampleEmployee->id}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('employees', ['id' => $this->sampleEmployee->id]);
    }

    /**
     * Admin permissions: CAN perform all CRUD operations.
     */
    public function test_admin_can_access_all_crud_operations(): void
    {
        $this->actingAs($this->adminUser);

        // 1. Can access create
        $this->get('/employees/create')->assertStatus(200);

        // 2. Can store employee
        $createResponse = $this->post('/employees', [
            'name' => 'Admin Created Employee',
            'gender' => 'Perempuan',
            'education' => 'S2',
            'age' => 33,
            'work_duration' => 8,
            'phone' => '081234567891',
            'email' => 'admin.created@example.com',
        ]);
        $createResponse->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', ['email' => 'admin.created@example.com']);

        // 3. Can access edit
        $this->get("/employees/{$this->sampleEmployee->id}/edit")->assertStatus(200);

        // 4. Can update employee
        $updateResponse = $this->put("/employees/{$this->sampleEmployee->id}", [
            'name' => 'Admin Updated Name',
            'gender' => 'Laki-laki',
            'education' => 'S2',
            'age' => 33,
            'work_duration' => 7,
            'phone' => '081234567890',
            'email' => 'existing.emp@example.com',
        ]);
        $updateResponse->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', ['name' => 'Admin Updated Name']);

        // 5. Can delete employee
        $deleteResponse = $this->delete("/employees/{$this->sampleEmployee->id}");
        $deleteResponse->assertRedirect('/employees');
        $this->assertDatabaseMissing('employees', ['id' => $this->sampleEmployee->id]);
    }
}

