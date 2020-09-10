<?php

namespace App;


use App\Fee;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    protected $hidden = array('pivot');
    protected $fillable = [
        "name",
        "code",
        "description",
        "valid_until",
        "account_per_client",
        "interest_calculation_method_id",

        "minimum_installment",
        "default_installment",
        "maximum_installment",

        "installment_length",
        "installment_method",

        "interest_interval",
        "interest_rate",
        

        "loan_minimum_amount",
        "loan_maximum_amount",

        "grace_period",
        "has_tranches",
        "number_of_tranches",

        "loan_portfolio_active",
        "loan_portfolio_in_arrears",
        "loan_portfolio_matured",

        "loan_interest_income_active",
        "loan_interest_income_in_arrears",
        "loan_interest_income_matured",

        "loan_write_off",
        "loan_recovery",
        "created_by",
        "status"
        
    ];

    public function fees(){
        return $this->belongsToMany(Fee::class,'loan_fee')->withTimestamps();
    }

}

