<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMerchantUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required',
            'email' => [
                'required',
                'email',
                Rule::unique('merchant_users', 'email')
                    ->ignore($this->id)
                    ->whereNull('deleted_at')
            ],
            'merchant_role_id' => 'bail|required|exists:merchant_roles,id',
            'status' => 'required',
            'merchant_store_ids.*' => 'required|exists:merchant_stores,id',
        ];
    }
}
