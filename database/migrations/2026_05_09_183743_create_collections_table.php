<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('loan_id')
                ->constrained('loans')
                ->cascadeOnDelete();

            $table->decimal('amount_paid', 12, 2);
            $table->string('payment_mode', 20);
            $table->string('location')->nullable();
            $table->timestamp('collected_at');

            $table->foreignId('collected_by')
                ->constrained('users');

            $table->timestamps();

            $table->index(['loan_id', 'collected_at']);
            $table->index('payment_mode');
            $table->index(['collected_by', 'collected_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
