<?php

namespace Tests\Feature;

use App\Modules\Auth\Models\User;
use App\Modules\Customer\Models\Customer;
use App\Modules\Loan\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_agent_can_add_collection(): void
    {
        $agent = User::factory()->create(['role' => 'agent']);
        $customer = Customer::factory()->create();

        $loan = Loan::factory()->create([
            'customer_id' => $customer->id,
            'total_amount' => 50000,
        ]);

        Sanctum::actingAs($agent);

        $response = $this->postJson('/api/v1/collections', [
            'loan_id' => $loan->id,
            'amount_paid' => 5000,
            'payment_mode' => 'cash',
            'collected_at' => now()->toDateTimeString(),
        ]);

        $response->assertCreated();
    }
}