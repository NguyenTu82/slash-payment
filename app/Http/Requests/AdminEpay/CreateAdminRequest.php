<?php

namespace App\Http\Requests\AdminEpay;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:admins,email,NULL,id,deleted_at,NULL',
            'role_id' => 'bail|required|exists:admin_roles,id',
            'password' => 'required|required_with:password_confirm|same:password_confirm|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/',
        ];
    }
}
