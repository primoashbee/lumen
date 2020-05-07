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
        'status',
        'repayment_date',
        'user_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:F d, Y',
    ];
    public function type(){
        return $this->belongsTo(Deposit::class,'deposit_id');
    }

    public function getBalanceAttribute($value){
        return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
    }

    public function deposit(array $data){
        
        $new_balance = $this->getRawOriginal('balance') + $data['amount'];
        DepositTransaction::create([
            'transaction_id' => uniqid(),
            'deposit_account_id' => $this->id,
            'transaction_type'=>'Deposit',
            'amount'=>$data['amount'],
            'payment_method'=>$data['payment_method'],
            'repayment_date'=>$data['repayment_date'],
            'user_id'=> auth()->user()->id,
            'balance' => $new_balance
        ]);
            
        
        $this->balance = $new_balance;
        return $this->save();
        
    }

    public function withdraw(array $data){
        if($this->getRawOriginal('balance') < $data['amount']){
            return false;
        }
        $new_balance = $this->getRawOriginal('balance') - $data['amount'];

        DepositTransaction::create([
            'transaction_id' => uniqid(),
            'deposit_account_id' => $this->id,
            'transaction_type'=>'Withdraw',
            'amount'=>$data['amount'],
            'payment_method'=>$data['payment_method'],
            'repayment_date'=>$data['repayment_date'],
            'user_id'=> auth()->user()->id,
            'balance' => $new_balance
        ]);
        
        $this->balance = $new_balance;
        return $this->save();        
    }

    public function transactions(){
        return $this->hasMany(DepositTransaction::class)->orderBy('created_at','desc');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id','client_id');
    }


}
