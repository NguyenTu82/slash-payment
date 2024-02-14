<?php

namespace App\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateProfileForm
{
    /**
     * @param Request $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore(auth('epay')->user()->id)->whereNull('deleted_at'),
            ],
            'name' => [
                'bail',
                'required',
            ],
            'role_id' => [
                'bail',
                'required',
                'exists:admin_roles,id',
            ],
        ]);

        return $validator->validate();
    }
}
