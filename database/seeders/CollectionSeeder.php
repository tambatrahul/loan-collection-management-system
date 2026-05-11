<?php

namespace Database\Seeders;

use App\Modules\Collection\Models\Collection;
use App\Modules\Loan\Models\Loan;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        Loan::all()->each(function (Loan $loan) {
            $collectionCount = rand(1, 4);

            $remaining = $loan->total_amount;

            for ($i = 0; $i < $collectionCount; $i++) {
                if ($remaining <= 0) {
                    break;
                }

                $amount = rand(
                    500,
                    min((int) $loan->emi_amount, (int) $remaining)
                );

                Collection::factory()->create([
                    'loan_id' => $loan->id,
                    'amount_paid' => $amount,
                    'payment_mode' => collect([
                        'cash',
                        'upi',
                        'card',
                    ])->random(),
                    'collected_by' => $loan->created_by,
                    'collected_at' => now()->subDays(rand(0, 30)),
                ]);

                $remaining -= $amount;
            }

            $paidAmount = $loan->collections()->sum('amount_paid');

            $loan->update([
                'status' => $paidAmount >= $loan->total_amount
                    ? 'completed'
                    : 'active',
            ]);
        });
    }
}
