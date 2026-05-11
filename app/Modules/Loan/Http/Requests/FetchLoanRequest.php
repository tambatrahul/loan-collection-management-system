<?php

namespace App\Modules\Loan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class FetchLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loan_no' => ['nullable', 'string'],
            'customer_name' => ['nullable', 'string'],
            'mobile' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}