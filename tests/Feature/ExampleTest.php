<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // 1. Guest can access login screen
        $this->get('/login')->assertStatus(200);

        // 2. Authenticated user can access employees
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user)->get('/employees')->assertStatus(200);
    }
}
