<?php

namespace App\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateNotiTemplateForm
{
    /**
     * validate
     *
     * @param \Illuminate\Http\Request $request
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'bail',
                'required'
            ],
            'content' => [
                'bail',
                'required',
            ]
        ]);
        return $validator->validate();
    }
}
