<?php

namespace App\Modules\Loan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CreateLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'emi_amount' => ['required', 'numeric', 'gt:0'],
            'total_amount' => ['required', 'numeric', 'gte:emi_amount'],
        ];
    }
}