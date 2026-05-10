<?php

namespace App\Modules\Collection\Models;

use Database\Factories\CollectionFactory;
use App\Modules\Auth\Models\User;
use App\Modules\Loan\Models\Loan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Collection extends Model
{
    use HasFactory;

    protected static function newFactory(): CollectionFactory
    {
        return CollectionFactory::new();
    }

    protected $fillable = [
        'loan_id',
        'amount_paid',
        'payment_mode',
        'location',
        'collected_at',
        'collected_by',
    ];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'collected_at' => 'datetime',
        ];
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collected_by');
    }
}