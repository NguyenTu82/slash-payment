<?php

namespace App\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateProfileUserForm
{
    /**
     * @throws ValidationException
     */
    public function validate(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($request->id)->whereNull('deleted_at')
            ],
            'name' => [
                'bail',
                'required'
            ],
            'role_id' => [
                'bail',
                'required',
                'exists:admin_roles,id',
            ],
            'status' => [
                'bail',
                'required',
            ]
        ]);

        return $validator->validate();
    }
}
