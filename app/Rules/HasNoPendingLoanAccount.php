<?php

namespace App\Rules;

use App\Client;
use Illuminate\Contracts\Validation\Rule;

class HasNoPendingLoanAccount implements Rule
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
        $res = Client::where('client_id',$value)->first()->loanAccounts->where('status','!=','Closed')->count() == 0;
        return $res;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Client has existing loan account';
    }
}
