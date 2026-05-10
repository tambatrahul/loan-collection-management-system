<?php

namespace App\Modules\Collection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class FetchCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loan_id' => ['nullable', 'integer'],
            'payment_mode' => ['nullable', 'string'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}