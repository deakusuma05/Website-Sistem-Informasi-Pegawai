<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($this->admin);
    }

    private function validEmployeeData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'John Doe',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 30,
            'work_duration' => 5,
            'phone' => '08123456789',
            'email' => 'john.doe@example.com',
        ], $overrides);
    }

    /**
     * Test 1: Empty name fails validation
     */
    public function test_empty_name_fails_validation(): void
    {
        $data = $this->validEmployeeData(['name' => '']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 2: Empty gender fails validation
     */
    public function test_empty_gender_fails_validation(): void
    {
        $data = $this->validEmployeeData(['gender' => '']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['gender']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 3: Empty education fails validation
     */
    public function test_empty_education_fails_validation(): void
    {
        $data = $this->validEmployeeData(['education' => '']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['education']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 4: Invalid email fails validation
     */
    public function test_invalid_email_fails_validation(): void
    {
        $data = $this->validEmployeeData(['email' => 'not-a-valid-email']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('employees', ['name' => $data['name']]);
    }

    /**
     * Test 5: Non-numeric age fails validation
     */
    public function test_non_numeric_age_fails_validation(): void
    {
        $data = $this->validEmployeeData(['age' => 'twenty-eight']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['age']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 5b: Out of range age (< 18 or > 100) fails validation
     */
    public function test_underage_and_overage_fail_validation(): void
    {
        $underage = $this->validEmployeeData(['age' => 15]);
        $response1 = $this->post('/employees', $underage);
        $response1->assertSessionHasErrors(['age']);

        $overage = $this->validEmployeeData(['age' => 105]);
        $response2 = $this->post('/employees', $overage);
        $response2->assertSessionHasErrors(['age']);
    }

    /**
     * Test 5c: Empty age fails validation
     */
    public function test_empty_age_fails_validation(): void
    {
        $data = $this->validEmployeeData(['age' => '']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['age']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 6: Negative work duration fails validation
     */
    public function test_negative_work_duration_fails_validation(): void
    {
        $data = $this->validEmployeeData(['work_duration' => -3]);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['work_duration']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 6b: Empty work duration fails validation
     */
    public function test_empty_work_duration_fails_validation(): void
    {
        $data = $this->validEmployeeData(['work_duration' => '']);
        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['work_duration']);
        $this->assertDatabaseMissing('employees', ['email' => $data['email']]);
    }

    /**
     * Test 7: Invalid phone fails validation (too short, or contains invalid characters)
     */
    public function test_invalid_phone_fails_validation(): void
    {
        // 7a: Phone too short (< 10 digits)
        $dataShort = $this->validEmployeeData(['phone' => '12345']);
        $responseShort = $this->post('/employees', $dataShort);
        $responseShort->assertSessionHasErrors(['phone']);

        // 7b: Phone with letters
        $dataLetters = $this->validEmployeeData(['phone' => 'invalid-phone-num']);
        $responseLetters = $this->post('/employees', $dataLetters);
        $responseLetters->assertSessionHasErrors(['phone']);

        // 7c: Empty phone
        $dataEmpty = $this->validEmployeeData(['phone' => '']);
        $responseEmpty = $this->post('/employees', $dataEmpty);
        $responseEmpty->assertSessionHasErrors(['phone']);
    }

    /**
     * Test: Old input preservation on validation error
     */
    public function test_old_input_is_preserved_on_validation_failure(): void
    {
        $data = [
            'name' => 'Preserved Name',
            'gender' => 'Laki-laki',
            'education' => 'S1',
            'age' => 25,
            'work_duration' => 2,
            'phone' => '08123456789',
            'email' => 'invalid-email-address', // Invalid
        ];

        $response = $this->post('/employees', $data);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasInput('name', 'Preserved Name');
        $response->assertSessionHasInput('gender', 'Laki-laki');
        $response->assertSessionHasInput('education', 'S1');
        $response->assertSessionHasInput('age', 25);
        $response->assertSessionHasInput('phone', '08123456789');
    }

    /**
     * Test: Valid inputs succeed and persist to database
     */
    public function test_valid_employee_passes_all_validations(): void
    {
        $data = $this->validEmployeeData([
            'phone' => '081234567890',
            'email' => 'valid.success@example.com',
            'age' => 35,
            'work_duration' => 8,
        ]);

        $response = $this->post('/employees', $data);

        $response->assertRedirect('/employees');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', 'Employee added successfully.');

        $this->assertDatabaseHas('employees', [
            'email' => 'valid.success@example.com',
            'phone' => '081234567890',
        ]);
    }
}

