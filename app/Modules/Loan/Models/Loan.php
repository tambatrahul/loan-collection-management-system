<?php

namespace App\Modules\Loan\Models;

use App\Modules\Auth\Models\User;
use Database\Factories\LoanFactory;
use App\Modules\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Loan extends Model
{
    use HasFactory;

    protected static function newFactory(): LoanFactory
    {
        return LoanFactory::new();
    }

    protected $fillable = [
        'loan_no',
        'customer_id',
        'emi_amount',
        'total_amount',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'emi_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function collections(): HasMany
    {
        return $this->hasMany(\App\Modules\Collection\Models\Collection::class);
    }

    public function getCollectedAmountAttribute(): float
    {
        return (float) ($this->collections_sum_amount_paid ?? 0);
    }

    public function getPendingAmountAttribute(): float
    {
        return (float) $this->total_amount - $this->collected_amount;
    }
}