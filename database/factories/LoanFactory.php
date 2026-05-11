<?php

namespace Database\Factories;

use App\Modules\Auth\Models\User;
use App\Modules\Loan\Models\Loan;
use App\Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Modules\Loan\Models\Loan>
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $totalAmount = fake()->numberBetween(10000, 100000);
        $emiAmount = fake()->numberBetween(1000, 10000);

        return [
            'loan_no' => 'LN' . fake()->unique()->numerify('#####'),
            'customer_id' => Customer::factory(),
            'emi_amount' => $emiAmount,
            'total_amount' => $totalAmount,
            'status' => 'active',
            'created_by' => User::factory()
        ];
    }
}