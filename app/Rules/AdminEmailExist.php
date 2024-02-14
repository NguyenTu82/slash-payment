<?php

namespace App\Rules;

use App\Helpers\Helper;
use App\Models\Admins;
use Illuminate\Contracts\Validation\Rule;

class AdminEmailExist implements Rule
{
    /**
     * @param string $message
     */
    protected string $input;

    /**
     * Create a new rule instance.
     *
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $admin = Admins::where("email", $value)->first();
        return $admin !== null;
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return __("common.error.not_exists_email");
    }
}
