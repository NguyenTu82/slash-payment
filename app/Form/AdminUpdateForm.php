<?php

namespace App\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminUpdateForm
{
    /**
     * @throws ValidationException
     */
    public function validate(Request $request): array
    {
        // Validations
        $validator = Validator::make($request->all(), [
            'name' => [
                'bail',
                'required',
                'max:100',
            ],
            'role_id' => [
                'bail',
                'required',
                'exists:admin_roles,id',
            ]
        ]);

        return $validator->validate();
    }
}
