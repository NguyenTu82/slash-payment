<?php

namespace App\Form\Merchant;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ChangPasswordForm
{
    /**
     * validate
     *
     * @param Request $request
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => [
                "required",
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/",
                "required_with:password_confirmation",
                "same:password_confirmation",
            ]
        ]);

        return $validator->validate();
    }
}
