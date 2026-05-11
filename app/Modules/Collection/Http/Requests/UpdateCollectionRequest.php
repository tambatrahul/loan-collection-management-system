<?php

namespace App\Modules\Collection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loan_id' => [
                'required',
                'integer',
                'exists:loans,id',
            ],
            'amount_paid' => [
                'required',
                'numeric',
                'min:1',
            ],
            'payment_mode' => [
                'required',
                Rule::in(['cash', 'upi', 'card']),
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'collected_at' => [
                'required',
                'date',
            ],
        ];
    }
}