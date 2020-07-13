<?php

namespace App\Rules;

use Carbon\Carbon;
use App\DepositAccount;
use Illuminate\Contracts\Validation\Rule;

class PreventLaterThanLastTransactionDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $deposit;
    public function __construct($deposit_id)
    {
        $this->deposit = DepositAccount::find($deposit_id);
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
        if($this->deposit->lastTransaction() == null){
            return true;
        }
        $last_transaction_date = Carbon::parse($this->deposit->lastTransaction()->repayment_date);
        
        if(Carbon::parse($value) < $last_transaction_date){
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
        return 'Repayment date should not be earlier than '.Carbon::parse($this->deposit->lastTransaction()->repayment_date)->format('F d, yy');
    }
}
