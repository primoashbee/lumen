<?php

namespace App\Rules;

use App\Office;
use Illuminate\Contracts\Validation\Rule;

class OfficeID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
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
        if($value=="[]"){
            return false;
        }
        if(Office::find($value)==null){
            return false;
        }
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You should select atleast 1 office';
    }
}
