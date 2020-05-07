<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositTransaction extends Model
{
    protected $fillable = ['deposit_account_id','transaction_type','transaction_id','amount','balance','payment_method','user_id','repayment_date'];
    protected $casts = [
        'created_at' => 'datetime:F d, Y',
    ];

    public function getAmountAttribute($value){
        return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
    }
    public function getBalanceAttribute($value){
        return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
    }
}
