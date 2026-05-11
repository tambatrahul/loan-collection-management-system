<?php

namespace Database\Factories;

use App\Modules\Collection\Models\Collection;
use App\Modules\Loan\Models\Loan;
use App\Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Collection>
 */
class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        return [
            'loan_id' => Loan::factory(),
            'amount_paid' => fake()->numberBetween(500, 5000),
            'payment_mode' => fake()->randomElement(['cash', 'upi', 'card']),
            'location' => fake()->city(),
            'collected_at' => now(),
            'collected_by' => User::factory()->agent(),
        ];
    }
}