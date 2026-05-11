<?php

namespace Tests\Feature;

use App\Modules\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_customer(): void
    {
        $admin = User::factory()->admin()->create();

        $agent = User::factory()->agent()->create();

        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/v1/customers', [
            'name' => 'Ramesh Patel',
            'mobile' => '9876543210',
            'address' => 'Mumbai',
            'assigned_to' => $agent->id,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('customers', [
            'name' => 'Ramesh Patel',
            'mobile' => '9876543210',
            'assigned_to' => $agent->id,
        ]);
    }
}