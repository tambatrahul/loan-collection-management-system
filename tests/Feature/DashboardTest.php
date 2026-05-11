<?php

namespace Tests\Feature;

use App\Modules\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_summary_endpoint_returns_success(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/dashboard/summary');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }
}