<?php

namespace App\Form\Merchant;

use App\Form\JSON;

/**
 * AdminCustomValidator
 * This call a form validator class
 */
class BaseValidatorCustom
{
    /**
     * validate
     *
     * @param $request
     * @param string $class
     * @return mixed
     */
    public function validate($request, string $class)
    {
        // Declare object
        $formValidator = str_replace("{{$class}}", $class, "\App\Form\Merchant\{$class}");
        $formValidator = new $formValidator();
        // Validate inputs
        $error = $formValidator->validate($request);

        return $error;
    }
}
