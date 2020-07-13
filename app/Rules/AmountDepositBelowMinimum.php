<?php

namespace App\Rules;

use App\Deposit;
use App\DepositAccount;
use Illuminate\Contracts\Validation\Rule;

class AmountDepositBelowMinimum implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $deposit;
    
    public function __construct($deposit)
    {
        
        $this->deposit =$deposit;
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
        
        if($value < $this->deposit->type->minimum_deposit_per_transaction){
            return false;
        }
        return true;
        // $index = explode('.', $attribute)[1];
        
        // $id = request()->input('accounts')[$index]['type']['id'];
        // $this->deposit = Deposit::find($id);
        // if($value < $this->deposit->minimum_deposit_per_transaction){
        //     return false;
        // }
        // return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Minimum deposit amount is : ' . $this->deposit->type->minimum_deposit_per_transaction;
    }
}
