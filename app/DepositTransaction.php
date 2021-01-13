<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DepositTransaction extends Model
{
    protected $fillable = ['deposit_account_id','transaction_type','transaction_id','amount','balance','payment_method','user_id','repayment_date'];
    protected $casts = [
        'created_at' => 'datetime:F d, Y',
    ];
    protected $dates = [
        'repayment_date',
    ];

    public function getAmountAttribute($value){
        return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
    }
    public function getBalanceAttribute($value){
        return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
    }
    public function paymentMethod(){
        return $this->hasOne(PaymentMethod::class,'id','payment_method');
    }
    public function postedBy(){
        return $this->belongsTo(User::class,'user_id');
    }

}
