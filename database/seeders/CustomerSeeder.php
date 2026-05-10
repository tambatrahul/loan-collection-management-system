<?php

namespace Database\Seeders;

use App\Modules\Auth\Models\User;
use App\Modules\Customer\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $agents = User::query()
            ->where('role', 'agent')
            ->get();

        Customer::factory()
            ->count(20)
            ->make()
            ->each(function (Customer $customer) use ($agents): void {
                $customer->assigned_to = $agents->random()->id;
                $customer->save();
            });
    }
}