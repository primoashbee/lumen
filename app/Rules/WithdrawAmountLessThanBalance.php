<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WithdrawAmountLessThanBalance implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $account;
    public function __construct($acc)
    {
        $this->account  = $acc;
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
        return $this->account->getRawOriginal('balance') < $value ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Withdrawal amount is greater than the actual balance ('.$this->account->balance.')';
    }
}
