<?php

namespace App\Rules;

use App\Models\TblAdmin;
use Illuminate\Contracts\Validation\Rule;

class UserEmailUnique implements Rule
{
    /**
     * @param array $input
     */
    protected $input;

    /**
     * Create a new rule instance.
     * @param array $input
     *
     * @return void
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $inputKeys = [];
        foreach ($this->input['id'] as $key => $item) {
            if ($this->input['email'][$key] == $value) {
                $id = $item;
                $inputKeys[] = $value;
            }
        }
        $uniqueAllKeyInputs = count(array_unique($inputKeys)) == count($inputKeys);
        if (isset($id)) {
            $countUser = TblAdmin::where('email', $value)
                ->where('id', '!=', $id)
                ->whereNull('deleted_at')->count();
        } else {
            $countUser = 0;
        }

        if ($uniqueAllKeyInputs !== true) {
            return false;
        }

        return $countUser == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}
