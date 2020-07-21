<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    protected $fillable = [

        'client_id',
        'loan_id',
        'interest_calculation_method_id',
        'installment',

        'tranch_1_amount',
        'tranch_2_amount',
        'tranch_3_amount',
        'tranch_4_amount',
        'tranch_5_amount',
        
        'created_by'

    ];


}
