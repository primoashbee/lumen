<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'name',
        'product_id',
        'description',
        'valid_until',
        'account_per_client',

        'interest_calculation_method_id',

        'minimum_installment',
        'default_installment',
        'maximum_installment',

        'installment_length',
        'installment_method',

        'interest_interval',
        'interest_rate',

        'loan_minimum_amount',

        'grace_period',

        'has_tranches',
        
        'loan_portfolio_active',
        'loan_portfolio_in_arrears',
        'loan_portfolio_matured',

        'loan_interest_income_active',
        'loan_interest_income_in_arrears',
        'loan_interest_income_matured',

        'loan_write_off',
        'loan_write_recovery',
    ];


    public static function mpl(){
        $me = new static;
        return $me::create([
            'name' => 'MULTI-PURPOSE LOAN',
            'product_id'=>'MPL',
            'description'=>'MPL YAN SIRRRR',
            
            'account_per_client'=>1,

            'interest_calculation_method_id'=>1,

            'minimum_installment'=>22,
            'default_installment'=>22,
            'maximum_installment'=>24,

            'installment_length'=>1,
            'installment_method'=>'days',

            'interest_interval'=>'monthly',
            'interest_rate'=>'5.475225',

            'loan_minimum_amount'=>2000,

            'grace_period'=>'No Grace Period',

            'loan_portfolio_active'=>22,
            'loan_portfolio_in_arrears'=>25,
            'loan_portfolio_matured'=>26,

            'loan_interest_income_active'=>98,
            'loan_interest_income_in_arrears'=>92,
            'loan_interest_income_matured'=>94,

            'loan_write_off'=>56,
            'loan_write_recovery'=>53,
        ]);
    }
}
