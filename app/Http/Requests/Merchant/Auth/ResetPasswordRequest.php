<?php

namespace App\Http\Requests\Merchant\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
            ],
            "token" => ["required"],
            "password" => [
                "required",
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/",
                "required_with:password_confirmation",
                "same:password_confirmation",
            ]
        ];
    }
}
