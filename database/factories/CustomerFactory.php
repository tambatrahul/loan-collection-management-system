<?php

namespace Database\Factories;

use App\Modules\Auth\Models\User;
use App\Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'mobile' => fake()->numerify('9#########'),
            'address' => fake()->address(),
            'assigned_to' => User::factory()->agent(),
        ];
    }
}