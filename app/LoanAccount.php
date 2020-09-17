<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    protected $fillable=[
        'client_id',
        'loan_id',
        'amount',
        'principal',
        'interest',
        'interest_rate',
        'number_of_installments',

        'total_deductions',
        'disbursed_amount', //net disbursement
        
        'approved_by',
        'approved',
        'approved_at',

        'disbursed_by',
        'disbursed_at',
        'disbursed',

        'first_payment',
        'last_payment',

        'created_by',
        'created_at',

        'notes'

    ];

    public function product(){
        return $this->belongsTo(Loan::class,'loan_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

}
