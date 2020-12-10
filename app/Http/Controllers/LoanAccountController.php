<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Client;
use Carbon\Carbon;
use App\LoanAccount;
use Illuminate\Http\Request;
use App\Rules\ClientHasActiveDependent;
use App\Rules\ClientHasAvailableDependent;
use App\Rules\HasNoPendingLoanAccount;
use App\Rules\HasNoUnusedDependent;
use App\Rules\LoanAmountModulo;
use App\Rules\PaymentMethodList;
use Illuminate\Support\Facades\Validator;

class LoanAccountController extends Controller
{
    public function index(Request $request){
        $client = Client::select('client_id','firstname','lastname')->where('client_id',$request->client_id)->firstOrFail();
        return view('pages.create-client-loan',compact('client'));
    }

    public function loanCreation(){
        $products = Loan::active();
        return response()->toJson(['data'=>array('loans'=>$products)],200);
    }

    public function calculate(Request $request){
        $this->validator($request->all())->validate();

        $client = Client::where('client_id',$request->client_id)->first();
        $loan =  Loan::find($request->loan_id);
        
        $fees = $loan->fees;
        $total_deductions = 0;

        $loan_amount = (int) $request->amount;
        $number_of_installments = $request->number_of_installments;
        $fee_repayments = array();
        $dependents = null;
        $unit_of_plan = 2;
        
        $dependents = $client->unUsedDependent()->pivotList();
        
        foreach($loan->fees as $fee){
            
            $fee_amount = $fee->calculateFeeAmount($loan_amount, $number_of_installments,$loan,$dependents);
            $total_deductions += $fee_amount;
            $fee_repayments[] = array(
                'name'=>$fee->name,
                'amount'=>$fee_amount
            );
        }
        
        $disbursed_amount = $loan_amount - $total_deductions;
        $annual_rate = 0.03 * 12;
        $start_date = $request->first_payment;
        
        $loan_interest_rate = Loan::rates($loan->id)->where('installments',$number_of_installments)->first()->rate;

        $data = array(
            'principal'=>$loan_amount,
            'annual_rate'=>$annual_rate,
            'interest_rate'=>$loan_interest_rate,
            'interest_interval'=>$loan->interest_interval,
            'disbursement_date'=>$loan->disbursement_date,
            'term'=>$loan->installment_method,
            'term_length'=>$number_of_installments,
            'start_date'=>$start_date,
            'office_id'=>$client->office->id
        );
        
        $calculator = LoanAccount::calculate($data);
        

        //dependent on calculator result.
        $data = array(
            'amount'=>$loan_amount,
            'client'=>Client::where('client_id',$request->client_id)->get(['client_id','firstname','lastname'])->makeHidden(['active_dependent']),
            
            'principal'=>$loan_amount,
            'formatted_principal'=>money($request->amount,2),
            
            'interest'=>$calculator->total_interest,
            'formatted_interest'=>money($calculator->total_interest,2),

            'total_loan_amount'=>$calculator->total_loan_amount,
            'formatted_total_loan_amount'=>money($calculator->total_loan_amount,2),
            
            'installments'=>$calculator->installments,
            'loan'=>$loan->get('name'),
            'fees'=>$fee_repayments,
            
            'total_deductions'=>$total_deductions,
            'formatted_total_deductions'=>money($total_deductions,2),
            
            'disbursement_amount'=>$disbursed_amount,
            'formatted_disbursement_amount'=>money($disbursed_amount,2),
            
            'number_of_installments' => $number_of_installments,
            'start_date'=>$calculator->start_date,
            'end_date'=>$calculator->end_date,
        );
        
        return response()->json(['data'=>$data],200);

    }

    public function validator(array $data,$for_update=false){
        
        if(!$for_update){
            $rules = [
                'loan_id'=>'required|exists:loans,id',
                'client_id'=>['required','exists:clients,client_id',new HasNoUnusedDependent],
                // 'client_id'=>['required','exists:clients,client_id',new HasNoPendingLoanAccount],
                'amount'=>['required','gte:2000',new LoanAmountModulo],
                'disbursement_date'=>'required|date',
                
                'first_payment'=>'required|date|after_or_equal:disbursement_date',
                'number_of_installments'=>'required|gt:0|integer',
                'interest_rate'=>'required', 
            ];
            return Validator::make(
                    $data,
                    $rules,
                );
        }
    }

    public function createLoan(Request $request){
        $this->validator($request->all())->validate();
        $client = Client::where('client_id',$request->client_id)->first();
        $loan =  Loan::find($request->loan_id);

        $fees = $loan->fees;
        $total_deductions = 0;

        $loan_amount = (int) $request->amount;
        $number_of_installments = $request->number_of_installments;
        $fee_repayments = array();
        
        $dependents = $client->unUsedDependent()->pivotList();
        foreach($loan->fees as $fee){
            $fee_amount = $fee->calculateFeeAmount($loan_amount, $number_of_installments,$loan,$dependents);
            $total_deductions += $fee_amount;
            $fee_repayments[] = (object)[
                'id'=>$fee->id,
                'name'=>$fee->name,
                'amount'=>$fee_amount
            ];
        }
        
        $disbursed_amount = $loan_amount - $total_deductions;
        $annual_rate = 0.03 * 12;
        $start_date = $request->first_payment;

        //get loan rates via loan and installment length
        $loan_interest_rate = Loan::rates($loan->id)->where('installments',$number_of_installments)->first()->rate;

        $data = array(
            'principal'=>$loan_amount,
            'annual_rate'=>$annual_rate,
            'interest_rate'=>$loan_interest_rate,
            'interest_interval'=>$loan->interest_interval,
            'term'=>$loan->installment_method,
            'term_length'=>$number_of_installments,
            'disbursement_date'=>$request->disbursement_date,
            'start_date'=>$start_date,
            'office_id'=>$client->office->id
        );
        
        
        $calculator = LoanAccount::calculate($data);
        
        //dependent on calculator result.

        \DB::beginTransaction();
        try{
            $loan_acc = $client->loanAccounts()->create([
                'loan_id'=>$loan->id,
                'amount'=>$loan_amount,
                'principal'=>$loan_amount,
                'interest'=>$calculator->total_interest,
                'total_loan_amount'=>$calculator->total_loan_amount,
                'interest_rate'=>$loan_interest_rate,
                'number_of_installments'=>$number_of_installments,

                'total_deductions'=>$total_deductions,
                'disbursed_amount'=>$disbursed_amount, //net disbursement
                
                            
                'total_balance'=>$loan_amount + $calculator->total_interest,
                'principal_balance'=>$loan_amount,
                'interest_balance'=>0,

                'disbursement_date'=>$calculator->disbursement_date,
                'first_payment_date'=>$calculator->start_date,
                'last_payment_date'=>$calculator->end_date,
                'created_by'=>auth()->user()->id,
            ]);;
        
            $this->createFeePayments($loan_acc,$fee_repayments);
            
            $this->createInstallments($loan_acc,$calculator->installments);
            $client->unUsedDependent()->update(['status'=>'For Loan Disbursement','loan_account_id'=>$loan_acc->id]);
            \DB::commit();
            return response()->json(['msg'=>'Loan Account successfully created'],200);
        }catch(\Exception $e){
            return response()->json(['msg'=>$e->getMessage()],500);

        }

        

        
    }

    public function createFeePayments($loan_acc, $fee_repayments){
        $fee_payments = array();
        foreach($fee_repayments as $fee){
            $fee_payments[] = $loan_acc->feePayments()->create([
                'fee_id'=> $fee->id,
                'amount'=> $fee->amount,
            ]);
        }
        return $fee_payments;
    }
    
    public function payFeePayments($fees,$payment_method_id,$disbursed_by,$transaction_id){
        $x = 1;
        $now  = Carbon::now();        
        foreach($fees as $fee){
            $res = $fee->update([
                'loan_account_disbursement_transaction_id'=>$transaction_id,
                'transaction_id'=>$fee->generateTransactionID($x),
                'paid_at'=>Carbon::now(),
                'paid_by'=>$disbursed_by,
                'payment_method_id'=>$payment_method_id,
                'paid'=>true,
                'created_at'=>$now
            ]);
            $x++;
        }
        return $res;
    }
    public function createInstallments($loan_acc,object $installments){
        $x=0;   //skip first installment
        $list = array();
        foreach($installments as $item){
            if ($x>0) {
                $list[] = $loan_acc->installments()->create([
                    'installment'=>$item->installment,
                    'date'=>$item->date,
                    'original_principal'=>$item->principal,
                    'original_interest'=>$item->interest,
                    'principal'=>$item->principal,
                    'interest'=>$item->interest,
                    
                    'principal_due'=>$item->principal,
                    'interest_due'=>$item->interest_due,
                    'amount_due'=>$item->amount_due,
                    'amortization'=>$item->amortization,
                    'principal_balance'=>$item->principal_balance,
                    'interest_balance'=>$item->interest_balance,
                ]);
            }
            $x++;
        }
        return $list;
    }

    public function clientLoanList($client_id){
        $client =  Client::with(['loanAccounts'=>function($q){
            return $q->orderBy('created_at','desc');
        }])->select('firstname','lastname','client_id')->where('client_id',$client_id)->firstOrFail();

        return view('pages.client-loans-list',compact('client'));
    }

    public function disburse($loan_id=null){
        
        if($loan_id!=null){
            $id = $loan_id;
        }else{
            $id = $this->id;
        }
        $account = LoanAccount::findOrFail($id);
        $fee_payments = $account->feePayments;
        $payment_method_id = 1;
        $disbursed_by = auth()->user()->id;
        \DB::beginTransaction();
        
        try {
            $transaction_id = $account->generateDisbursementTransactionNumber();
            $this->payFeePayments($fee_payments,$payment_method_id,$disbursed_by,$transaction_id);

            $account->update([
                'disbursed_at'=>Carbon::now(),
                'status'=>'Active',
                'disbursed'=>true
            ]);
            
            $account->disbursement()->create([
                'transaction_id'=>$transaction_id,
                'disbursed_amount'=>$account->disbursed_amount,
                'disbursed_by'=>auth()->user()->id,
                'payment_method_id'=>$payment_method_id 
            ]);
        
        $account->updateAccount();
        $account->dependents->update([
            'status'=>'Used',
            'loan_account_id'=>$account->id,
            'activated_at'=>Carbon::now(),
            'expires_at'=>Carbon::now()->addDays(env('INSURANCE_MATURITY_DAYS'))
            ]);
        \DB::commit();
        return redirect()->back();
        }catch(\Exception $e){
            return response()->json(['msg'=>$e->getMessage()],500);
    
        }
        return redirect()->back();
    }

    public function approve($loan_id=null){
        
        if($loan_id!=null){
            $id = $loan_id;
        }else{
            $id = $this->id;
        }
        \DB::beginTransaction();
        
        try{
            LoanAccount::findOrFail($id)->update([
                'approved_by'=>auth()->user()->id,
                'approved_at'=>Carbon::now(),
                'status'=>'Approved',
                'approved'=>true
            ]);
            \DB::commit();
            return redirect()->back();
        }catch(\Exception $e){ 
            return response()->json(['msg'=>$e->getMessage()],500);
        }

        
    }
    public function account(Request $request, $client_id,$loan_id){

        if($request->wantsJson()){
            $account = LoanAccount::find($loan_id)->append('mutated','total_paid','pre_term_amount','activity');
            
            $client = Client::select('firstname','lastname','client_id')->where('client_id',$client_id)->first();
            
            
            $activity = $account->activity();
            return response()->json([
                'account'=>$account->load('installments'),
                'client'=>$client,
                // 'pre_term_amount'=>$preterm,
                // 'activity'=>$activity
            ],200);
        }
        
        $account =  LoanAccount::findOrFail($loan_id);
        
        $client = Client::where('client_id',$client_id)->firstOrFail();
        return view('pages.client-loan-account',compact('account','client'));
    }

    // public function wantsJson(Request $request){
    //     return $request->wantsJson();
    // }
    
}
