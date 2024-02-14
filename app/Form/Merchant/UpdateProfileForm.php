<?php

namespace App\Form\Merchant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateProfileForm
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
                'email',
                Rule::unique('merchant_users', 'email')->ignore(auth('merchant')->user()->id)->whereNull('deleted_at'),
            ],
            'name' => [
                'bail',
                'required',
            ],
            'merchant_role_id' => [
                'bail',
                'filled',
                'exists:merchant_roles,id',
            ],
        ]);

        return $validator->validate();
    }
}
