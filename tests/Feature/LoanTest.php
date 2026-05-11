<?php

namespace Tests\Feature;

use App\Modules\Auth\Models\User;
use App\Modules\Customer\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_loan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = Customer::factory()->create();

        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/v1/loans', [
            'loan_no' => 'LN1001',
            'customer_id' => $customer->id,
            'emi_amount' => 5000,
            'total_amount' => 50000,
        ]);

        $response->assertCreated();
    }
}