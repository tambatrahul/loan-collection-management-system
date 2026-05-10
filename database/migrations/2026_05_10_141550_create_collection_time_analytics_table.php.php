<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_time_analytics', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('analytics_date');

            // 0, 2, 4, ..., 22
            $table->unsignedTinyInteger('slot_start_hour');

            $table->unsignedInteger('total_collections')->default(0);

            $table->decimal('total_amount', 15, 2)->default(0);

            $table->timestamp('last_refreshed_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['user_id', 'analytics_date', 'slot_start_hour'],
                'collection_time_analytics_unique'
            );

            $table->index(
                ['user_id', 'analytics_date'],
                'collection_time_analytics_user_date_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_time_analytics');
    }
};