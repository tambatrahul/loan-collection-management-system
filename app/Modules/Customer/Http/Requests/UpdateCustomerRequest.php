<?php

namespace App\Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = (int) $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                'string',
                'max:15',
                Rule::unique('customers', 'mobile')->ignore($customerId),
            ],
            'address' => ['required', 'string'],
            'assigned_to' => ['required','exists:users,id']
        ];
    }
}
