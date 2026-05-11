<?php

namespace Database\Seeders;

use App\Modules\Customer\Models\Customer;
use App\Modules\Loan\Models\Loan;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        Customer::query()->each(function (Customer $customer): void {
            Loan::factory()->create([
                'customer_id' => $customer->id,
                'created_by' => $customer->assigned_to,
            ]);
        });
    }
}