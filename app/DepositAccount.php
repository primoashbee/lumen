<?php

namespace App;

use App\Deposit;
use Illuminate\Database\Eloquent\Model;

class DepositAccount extends Model
{
    //

    protected $fillable = [
        'client_id',
        'deposit_id',
        'balance',
        'accrued_interest',
        'status'
    ];
 
    public function type(){
        return $this->belongsTo(Deposit::class,'deposit_id');
    }

    public function getBalanceAttribute($value){
        return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
    }
}
