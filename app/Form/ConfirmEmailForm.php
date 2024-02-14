<?php

namespace App\Form;

use App\Rules\AdminEmailExist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfirmEmailForm
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
            "email" => [
                "bail",
                "required",
                "string",
                "email",
                "max:100"
            ],
        ]);
        return $validator->validate();
    }
}
