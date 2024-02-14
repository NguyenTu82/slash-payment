<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class CreateMerchantUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:merchant_users,email,NULL,id,deleted_at,NULL',
            'merchant_role_id' => 'bail|required|exists:merchant_roles,id',
            'password' => 'required|required_with:password_confirm|same:password_confirm|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/',
            'merchant_store_ids.*' => 'required|exists:merchant_stores,id',
        ];
    }
}
