<?php

namespace App;

use App\PaymentMethod;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class LoanAccountRepayment extends Model
{
    // use MoneyMutator;

    protected $fillable = [
        'loan_account_id',
        'interest_paid',
        'principal_paid',
        'total_paid',
        'carried_over_amount',
        'paid_by',
        'payment_method_id',
        'repayment_date',
        'for_pretermination',
        'notes',
        'transaction_id',
        'reverted',
        'reverted_by',
    ];
    
    protected $dates = ['created_at','updated_at','repayment_date','mutated'];
    protected $appends = ['mutated'];
    protected $for_mutation =['interest_paid','total_paid','principal_paid'];

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }
    public function loanAccount(){
        return $this->belongsTo(LoanAccount::class);
    }

    public function paidBy(){
        return $this->belongsTo(User::class,'paid_by');
    }
    public function getMutatedAttribute(){
        $fields = $this->for_mutation;
        
        foreach($fields as $field){
            $attribute = $field;
            $mutated[$attribute] = env('CURRENCY_SIGN') . ' ' . number_format($this->$field,2);
        }
        $mutated['particulars'] = 'Loan Repayment';
        if($this->for_pretermination){
            $mutated['particulars'] = 'Pre-Termination';
        }
        
        $mutated['paid_by'] = $this->paidBy->fullname;
        $mutated['payment_method'] = $this->paymentMethod->name;

        return $mutated;
        
    }
    public function installmentRepayments(){
        return LoanAccountInstallmentRepayment::where('transaction_id',$this->transaction_id)->orderBy('id','desc')->get();
    }


    public function revert($user_id){
        if($this->reverted){
            return false;
        }
        if($this->hasTransactionBefore()){
            return false;
        }


        //LoanAccountInstallmentRepayments Instance
        $repayments = $this->installmentRepayments();
        
        //iterate to affected installments
        foreach($repayments as $item){
            $installment = $item->installment;
            $interest_paid = $item->interest_paid;
            $principal_paid = $item->principal_paid;
           

            $interest_due = $installment->interest_due;
            $principal_due = $installment->principal_due;

            $new_interest = round($interest_paid + $interest_due,2);
            $new_principal = round($principal_paid + $principal_due,2);
            $new_amount_due = round($new_interest + $new_principal ,2);

            $new_interest_paid = round($installment->interest_paid - $interest_paid,2);
            $new_principal_paid = round($installment->principal_paid - $principal_paid,2);
            $res = !$installment->isFuture();
            $has_payment = $installment->repayments->count() - 1 > 0;
            if($res){
                $installment->update([
                    'interest_due'=>$new_interest,
                    'principal_due'=>$new_principal,
                    'amount_due'=>$new_amount_due,
                    'paid'=>false,
                    'interest_paid'=>$new_interest_paid,
                    'principal_paid'=>$new_principal_paid,
                    'has_payment'=>$has_payment
                ]);
            }else{
                $new_interest = round($installment->interest + $interest_paid,2);
                $new_principal = round($installment->principal + $principal_paid,2);
                $new_interest_paid = round($installment->interest_paid - $interest_paid,2);
                $new_principal_paid = round($installment->principal_paid - $principal_paid,2);
                $installment->update([
                   'interest_due'=>0,
                   'principal_due'=>$principal_due,
                   'interest'=>$new_interest,
                   'principal'=>$new_principal, 
                   'paid'=>false,
                   'interest_paid'=>$new_interest_paid,
                   'principal_paid'=>$new_principal_paid,
                   
                ]);
            }
        }
        LoanAccountInstallmentRepayment::where('transaction_id',$this->transaction_id)->delete();
        return $this->update([
            'reverted'=>true,
            'reverted_by'=>$user_id
        ]);

        
        
    }
    
   
    public function hasTransactionBefore(){
        $id = $this->id;
        $loan_account_id = $this->loan_account_id;
        $transactions = LoanAccountRepayment::where('loan_account_id',$loan_account_id)->where('reverted',false)->orderBy('id','desc');

        if($transactions->count() > 1){
            
            return $transactions->first()->id  > $this->id ? true : false;
        }
        //has no transaction or first transaction
        return false;

    }

    public function revertPreTermination($user_id){
        $interest_paid = $this->interest_paid;
        $principal_paid = $this->principal_paid;
        $amount_paid = $this->amount_paid;
        $loan_account = $this->loanAccount;

        $new_interest = round($interest_paid * 2,2);
        if($new_interest > $loan_account->interest){
            $new_interest = $loan_account->interest;
        }

        $new_principal = $principal_paid;
        $transaction_id = $this->transaction_id;
        $new_total_balance = round($new_interest + $new_principal,2);

        $installments = LoanAccountInstallmentRepayment::where('transaction_id',$transaction_id)->orderBy('id','desc')->get();
        
        foreach($installments as $item){
            $installment_new_interest = round($item->installment->interest + $item->interest_paid,2);
            $installment_new_principal = round($item->installment->principal + $item->interest_paid,2);
            $has_payment = LoanAccountInstallmentRepayment::where('loan_account_installment_id',$item->loan_account_installment_id)
                ->where('transaction_id','!=',$item->transaction_id)
                ->count() > 0;
            $item->installment->update([
                'interest'=>$installment_new_interest,
                'principal'=>$installment_new_principal,
                'principal_due'=>$installment_new_principal,
                'paid'=>false,
                'has_payment'=>$has_payment
            ]);
            $item->installment->updatePaymentFromPreterm($item->interest_paid,$item->principal_paid,true);
            $item->delete();
        }
        $this->update([
            'reverted'=>true,
            'reverted_by'=>$user_id
        ]);
        return $loan_account->update([
            'interest_balance'=>$new_interest,
            'principal_balance'=>$principal_paid,
            'total_balance'=>$new_total_balance
        ]);
        
    }

    

    


    
}
