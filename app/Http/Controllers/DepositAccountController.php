<?php

namespace App\Http\Controllers;

use App\DepositAccount;
use App\Rules\OfficeID;
use App\Rules\PreventFutureDate;
use App\Rules\TransactionType;
use App\Rules\WithdrawAmountLessThanBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositAccountController extends Controller
{
    

    public function deposit($deposit_account_id,Request $request){
        $this->validator($request->all())->validate();
        if ($request->type == 'deposit') {
            DepositAccount::find($deposit_account_id)->deposit($request->all());
            return response()->json(['msg'=>'Deposit Transaction Succesful'],200);
        }elseif ($request->type=='withdraw'){
            DepositAccount::find($deposit_account_id)->withdraw($request->all());
            return response()->json(['msg'=>'Withdrawal Transaction Succesful'],200);
        }
        
    }

    public function validator(array $data){
        
        $acc = DepositAccount::find($data['deposit_account_id']);
        $minimum = 0;
        if($acc !== null){
            $minimum = $acc->type->minimum_deposit_per_transaction;
        } 
        if($data['type']=="withdraw"){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'amount'=>['required','numeric',new WithdrawAmountLessThanBalance($acc)],
                'payment_method'=>['required'],
                'deposit_account_id'=>['required','exists:deposit_accounts,id'],
                'repayment_date'=>['required','date', new PreventFutureDate()],
                'type'=>['required', new TransactionType()]
            ];
        }elseif($data['type']=="deposit"){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'amount'=>['required','gte:'.$minimum,'numeric'],
                'payment_method'=>['required'],
                'deposit_account_id'=>['required','exists:deposit_accounts,id'],
                'repayment_date'=>['required','date', new PreventFutureDate()],
                'type'=>['required', new TransactionType()]
            ];
        }
        return Validator::make(
            $data, 
            $rules
        );
    }
}
