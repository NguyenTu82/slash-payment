<?php

namespace App\Form;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminVerifyForm
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
                    "required_with:password_confirm",
                    "same:password_confirm",
                ],
            ],
            [
                "password.regex" => __("as0015_0017.password_new_regex"),
            ]
        );

        return $validator->validate();
    }
}
