<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PairRule implements Rule
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
        $allPairs = array_keys(config('trackable_drivers.tracked_pairs'));

        return in_array($value, $allPairs);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The provided pair is not-trackable by this software!';
    }
}
