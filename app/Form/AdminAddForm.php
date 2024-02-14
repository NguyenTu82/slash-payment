<?php

namespace App\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminAddForm
{
    /**
     * validate
     *
     * @param \Illuminate\Http\Request $request
     */
    public function validate(Request $request)
    {
        // Validations
        $validator = Validator::make($request->all(), [
            'name' => [
                'bail',
                'required',
                'max:100',
            ],
            'role' => [
                'bail',
                'required',
                'exists:admin_roles,id',
            ],
            'status' => [
                'bail',
                'required',
            ],
            "email" => "bail|required|string|email|max:100|unique:admins",
            "password" => [
                'bail',
                "required",
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/",
                "required_with:password_confirmation",
                "same:password_confirmation",
            ],
        ]);
        return $validator->validate();
    }
}
