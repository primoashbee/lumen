<?php

namespace App;

use App\Deposit;
use App\DepositTransaction;
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

    public function deposit($value){
        
        $trans = DepositTransaction::create([
            'deposit_account_id' => $this->client_id,
            'transaction_type'=>'deposit',
            'amount'=>$value,
            'payment_method'=>'CASH IN BANK'
        ]);
        
        
        
        $this->balance = $this->getRawOriginal('balance') + $value;
        return $this->save();
        
    }

    public function withdraw($value){
        if($this->getRawOriginal('balance') < $value){
            return false;
        }
        DepositTransaction::create([
            'deposit_account_id' => $this->client_id,
            'transaction_type'=>'withdraw',
            'amount'=>$value,
            'payment_method'=>'CASH IN BANK'
        ]);
        
        
        
        $this->balance = $this->getRawOriginal('balance') - $value;
        return $this->save();
        
    }
}
