<?php

namespace App\Rules;
use App\Office;
use Illuminate\Contracts\Validation\Rule;

class OfficeLevel implements Rule
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
        $levels = Office::schema()->pluck('level')->toArray();
        return in_array($value,$levels) ?  true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please choose atleast 1 Office Level';
    }
}
