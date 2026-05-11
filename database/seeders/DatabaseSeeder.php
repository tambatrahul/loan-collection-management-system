<?php

namespace Database\Seeders;

use App\Modules\Dashboard\Jobs\RefreshCollectionTimeAnalyticsJob;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            LoanSeeder::class,
            CollectionSeeder::class,
        ]);

        // Generate analytics data
        dispatch_sync(new RefreshCollectionTimeAnalyticsJob());
    }
}