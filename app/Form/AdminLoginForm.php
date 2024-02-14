<?php

namespace App\Form;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminLoginForm
{
    /**
     * validate
     *
     * @param \Illuminate\Http\Request $request
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'bail',
                'required',
                'email'
            ],
            'password' => [
                'required'
            ]
        ]);

        return $validator->validate();
    }
}
