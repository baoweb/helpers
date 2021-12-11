<?php

namespace Baoweb\Helpers\Rules;

use Illuminate\Contracts\Validation\Rule;

class CzechNumericNonNegative implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $value = str_replace(',', '.', $value);

        return is_numeric($value) && $value >= 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute price must be a non-negative number with decimal dot or decimal comma.';
    }
}
