<?php

namespace App\Http\Controllers;

use App\Office;
use App\DepositAccount;
use App\Rules\OfficeID;
use App\Rules\PaymentMethod;
use Illuminate\Http\Request;
use App\Rules\TransactionType;
use App\Rules\PaymentMethodList;
use App\Rules\PreventFutureDate;
use Illuminate\Support\Facades\Validator;
use App\Rules\WithdrawAmountLessThanBalance;

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
                'payment_method'=>['required',new PaymentMethod()],
                'deposit_account_id'=>['required','exists:deposit_accounts,id'],
                'repayment_date'=>['required','date', new PreventFutureDate()],
                'type'=>['required', new TransactionType()]
            ];
        }elseif($data['type']=="deposit"){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'amount'=>['required','gte:'.$minimum,'numeric'],
                'payment_method'=>['required', new PaymentMethod()],
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

    public function showList(Request $request){
        if($request->product_id=="ALL"){
            $request->product_id = null;
        }
        $accounts = Office::depositAccounts($request->office_id,$request->product_id)->paginate(20);
        return response()->json(['accounts' => $accounts], 200);

    }

    public function bulkDeposit(Request $request){
        $this->validateBulk($request->all(),'deposit')->validate();
    }

    public function validateBulk(array $data,$type=null){
        $data = $data;
        $rules = [];
        $msgs = [];
        
        if ($type=='deposit') {
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'repayment_date'=>['required','date', new PreventFutureDate()],
                'payment_method'=>['required', new PaymentMethodList()],
                'type'=>['required', new TransactionType()],
                'accounts.*.deposit_id'=> ['required','exists:deposit_accounts,id'],
                'accounts.*.amount'=> ['required','exists:deposit_accounts,id'],
            ];

            $msgs = [
                'accounts.*.amount.required'=> ['Amount is not enough']
            ];
        }

        return Validator::make($data, $rules,$msgs);
        

    }
}
