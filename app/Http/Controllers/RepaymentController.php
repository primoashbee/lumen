<?php

namespace App\Http\Controllers;

use App\LoanAccount;
use App\LoanAccountRepayment;
use App\Rules\OfficeID;
use Illuminate\Http\Request;
use App\Rules\PaymentMethodList;
use App\Rules\PreventFutureDate;
use App\Rules\AccountMustBeActive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RepaymentController extends Controller
{
    
    public function accountPayment(Request $request){
        
        $this->validator($request->all())->validate();
        $account = LoanAccount::find($request->loan_account_id);
        
        
        \DB::beginTransaction();
        
        try{
            $account = LoanAccount::find($request->loan_account_id);
            $request->request->add(['paid_by'=>auth()->user()->id]);
            $request->request->add(['user_id'=>auth()->user()->id]);
            $account->pay($request->all());
        
            \DB::commit();
            
            $account->fresh()->updateAccount();
            return response()->json(['msg'=>'Payment Successfully Received!'],200);
        }catch(\Exception $e){
            return response()->json(['msg'=>$e->getMessage()],500);
        }

    }

    public function distributePayment($payment,$installment){
        $interest_due = $installment->interest_due;
        $principal_due = $installment->principal_due;
        $due = $installment->amount_due;
        $distributed = [];

        if($payment >= $due){
            $payment -= $interest_due;
            $distributed['interest_due'] = $interest_due;
            $payment -= $principal_due;
            $distributed['principal_due'] = $principal_due;
            $distributed['remaining'] = $payment;
        }

        dd($distributed);
        return $distributed;
    }

    public function validator(array $data){
        $rules = [
            'office_id' =>['required', new OfficeID()],
            'repayment_date'=>['required','date', new PreventFutureDate(),'prevent_previous_repayment_date','on_or_before_disbursement_date'],
            'payment_method'=>['required', new PaymentMethodList],
            'loan_account_id'=>['required', 'numeric','exists:loan_accounts,id',new AccountMustBeActive],
            'amount' => ['required','gt:0','maximum_loan_repayment','ctlp'],
            
        ];
        $messages =[
            'office_id.required'=>'Level is required',
            'repayment_date.required'=>'Repayment Date is required',
            'repayment_date.date'=>'Repayment Date must be a date',
            'loan_account_id.required'=>'Loan is invalid',
            'loan_account_id.exists'=>'Loan is invalid',
            'amount.required'=>'Amount is required',
            'amount.gt'=>'Amount must be greater than 0',
            'amount.numeric'=>'Invalid Amount Data Type',
        ];
        return Validator::make($data,$rules,$messages);
    }

    public function preTerminate(Request $request){
        $request->validate([
            'office_id' =>['required', new OfficeID()],
            'repayment_date'=>['required','date', new PreventFutureDate(),'prevent_previous_repayment_date'],
            'payment_method'=>['required', new PaymentMethodList],
            'loan_account_id'=>['required', 'numeric','exists:loan_accounts,id',new AccountMustBeActive],
            'amount'=>['ctlp']
        ]);

        \DB::beginTransaction();
        try{
            $request->request->add(['paid_by'=>auth()->user()->id]);
            $request->request->add(['user_id'=>auth()->user()->id]);
            $acc = LoanAccount::find($request->loan_account_id)->preTerminate($request->all());
            \DB::commit();
            return response()->json(['msg'=>'Transaction Successful'],200);
        }catch(Exception $e){
            return response()->json(['msg'=>$e->getMessage()],422);
        }
    }
}
