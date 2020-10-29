<?php

namespace App;

use App\PaymentMethod;
use App\Traits\MoneyMutator;
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

    

    


    
}
