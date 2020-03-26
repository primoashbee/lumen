<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EducationalAttainment implements Rule
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
        $types = ["ELEMENTARY","HIGH SCHOOL","VOCATIONAL","COLLEGE"];
        return in_array($value,$types) ?  true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must select valid educational attainment.';
    }
}
