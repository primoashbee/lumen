<?php

namespace App\Http\Controllers;

use App\Office;
use App\DepositAccount;
use App\Http\Requests\SampleRequest;
use App\PaymentMethod;
use App\Rules\AmountDepositBelowMinimum;
use App\Rules\OfficeID;
use App\Rules\PreventLaterThanLastTransactionDate;
use Illuminate\Http\Request;
use App\Rules\TransactionType;
use App\Rules\PaymentMethodList;
use App\Rules\PreventFutureDate;
use Illuminate\Support\Facades\Validator;
use App\Rules\WithdrawAmountLessThanBalance;

class DepositAccountController extends Controller
{
    

    public function deposit($deposit_account_id,Request $request){
        $data = $request->all();
        $this->validator($request->all())->validate();
        $request->request->add(['user_id'=>auth()->user()->id]);
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
        
        if($data['type']=="withdraw"){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'amount'=>['required','numeric',new WithdrawAmountLessThanBalance($acc)],
                'payment_method'=>['required',new PaymentMethodList()],
                'deposit_account_id'=>['required','exists:deposit_accounts,id'],
                'repayment_date'=>['required','date', new PreventFutureDate(), new PreventLaterThanLastTransactionDate($data['deposit_account_id'])],
                'type'=>['required', new TransactionType()]
            ];
        }elseif($data['type']=="deposit"){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'amount'=>['required','numeric',new AmountDepositBelowMinimum($acc)],
                'payment_method'=>['required', new PaymentMethodList()],
                'deposit_account_id'=>['required','exists:deposit_accounts,id'],
                'repayment_date'=>['required','date', new PreventFutureDate(), 'prevent_previous_deposit_transaction_date'],
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
    public function validateBulk(array $data,$type=null){
        $data = $data;
        
        $rules = [];
        
        if($type=='deposit'){
            
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'accounts.*.repayment_date'=>['required','date', new PreventFutureDate(),'prevent_previous_deposit_transaction_date'],
                'payment_method'=>['required', new PaymentMethodList()],
                'type'=>['required', new TransactionType()],        
                'accounts.*.deposit_id'=> ['required','exists:deposit_accounts,id'],
                'accounts.*.amount'=> ['required', 'cbu_deposit:accounts.*.amount','gt:0','integer'],
                ];

            $messages = [];
        }else if($type=='withdraw'){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'repayment_date'=>['required','date', new PreventFutureDate(), 'prevent_previous_deposit_transaction_date'],
                'payment_method'=>['required', new PaymentMethodList()],
                'type'=>['required', new TransactionType()],        
                'accounts.*.deposit_id'=> ['required','exists:deposit_accounts,id'],
                'accounts.*.amount'=> ['gt:0','cbu_withdraw:accounts.*.amount','integer'],
            ];

            $messages = [];
        }else if($type=="post_interest"){
            $rules = [
                'office_id' =>['required', new OfficeID()],
                'repayment_date'=>['required','date', new PreventFutureDate()],
                'payment_method'=>['required', new PaymentMethodList()],
                'type'=>['required', new TransactionType()],        
                'accounts.*.deposit_id'=> ['required','exists:deposit_accounts,id'],
            ];

            $messages = [];
        }
        return Validator::make($data, $rules,$messages);
    }
    public function postInterestByUser(Request $request){
        
        $validator = Validator::make($request->all(),
            [
                'deposit_account_id'=>['required','exists:deposit_accounts,id']
            ]
        );

        if($validator->passes()){
            return DepositAccount::find($request->deposit_account_id)->postInterestByUser(auth()->user()->id);
        }
    }
    public function showBulkView(Request $request){
        return view('pages.bulk.deposit');
    }

    public function bulkDeposit(Request $request){
        $this->validateBulk($request->all(),'deposit')->validate();

        $total_amount = 0;
        $accounts_total = 0;
        foreach($request->accounts as $account){
            
            $current = DepositAccount::find($account['id']);
            $deposit_info = array(
                'amount' => $account['amount'],
                'payment_method'=>$request->payment_method,
                'repayment_date'=>$request->repayment_date,
                'user_id'=>auth()->user()->id
            );
            $current->deposit($deposit_info);
            $total_amount = $total_amount + $account['amount'];
            $accounts_total = $accounts_total + 1;
        }
        $response = array(
            'total_amount' => env('CURRENCY_SIGN').' '.number_format($total_amount,2,'.',','),
            'payment_method'=>PaymentMethod::find($request->payment_method)->name,
            'office' => Office::find($request->office_id)->name,
            'accounts_total' => number_format($accounts_total)
        );
        return response()->json([$response ], 200);
        
    }
    public function bulkWithdraw(Request $request){
        $this->validateBulk($request->all(),'withdraw')->validate();
        $total_amount = 0;
        $accounts_total = 0;
        foreach($request->accounts as $account){
            
            $current = DepositAccount::find($account['id']);
            $withdrawal_info = array(
                'amount' => $account['amount'],
                'payment_method'=>$request->payment_method,
                'repayment_date'=>$request->repayment_date,
            );
            $current->withdraw($withdrawal_info);
            $total_amount = $total_amount + $account['amount'];
            $accounts_total = $accounts_total + 1;
        }
        $response = array(
            'total_amount' => env('CURRENCY_SIGN').' '.number_format($total_amount,2,'.',','),
            'payment_method'=>PaymentMethod::find($request->payment_method)->name,
            'office' => Office::find($request->office_id)->name,
            'accounts_total' => number_format($accounts_total)
        );
        return response()->json([$response ], 200);
    }
    public function bulkPostInterest(Request $request){
        $this->validateBulk($request->all(),'post_interest')->validate();
        $total_amount = 0;
        $accounts_total = 0;
        foreach($request->accounts as $account){
            
            $current = DepositAccount::find($account['id']);
            $payment_info = array(
                'payment_method'=>$request->payment_method,
                'repayment_date'=>$request->repayment_date,
            );
            $current->postInterestByUser(auth()->user()->id, $payment_info);
            $total_amount = $total_amount + $account['accrued_interest'];
            $accounts_total = $accounts_total + 1;
        }
        $response = array(
            'total_amount' => env('CURRENCY_SIGN').' '.number_format($total_amount,2,'.',','),
            'payment_method'=>PaymentMethod::find($request->payment_method)->name,
            'office' => Office::find($request->office_id)->name,
            'accounts_total' => number_format($accounts_total)
        );
        return response()->json([$response ], 200);
    }
}
