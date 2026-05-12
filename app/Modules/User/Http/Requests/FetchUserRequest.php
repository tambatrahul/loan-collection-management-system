<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class FetchUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'role' => ['nullable', Rule::in(['admin', 'agent'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}