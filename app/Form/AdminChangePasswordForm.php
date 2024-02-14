<?php

namespace App\Form;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminChangePasswordForm
{
    /**
     * validate
     *
     * @param \Illuminate\Http\Request $request
     */
    public function validate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "password" => [
                    "required",
                    "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/",
                    "required_with:password_confirmation",
                    "same:password_confirmation",
                ],
                "token" => ["required"],
            ]
        );

        return $validator->validate();
    }
}
