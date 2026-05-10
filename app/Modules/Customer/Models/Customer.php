<?php

namespace App\Modules\Customer\Models;

use App\Modules\Auth\Models\User;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }

    protected $fillable = [
        'name',
        'mobile',
        'address',
        'assigned_to'
    ];

    public function assignedAgent()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }
}