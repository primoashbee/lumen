<?php

namespace App;

use App\LoanAccountInstallment;
use Illuminate\Database\Eloquent\Model;

class LoanAccountInstallmentRepayment extends Model
{
    protected $fillable =[
        'interest_paid',
        'principal_paid',
        'total_paid',
        'transaction_id',
        'paid_by',
        'reverted'
    ];

    public function installment(){
        return $this->belongsTo(LoanAccountInstallment::class,'loan_account_installment_id');
    }

    public function revertPayment($item){
        $installment = $this->installment;
        $returned_interest = $item->interest_paid;
        $returned_principal = $item->principal_paid;
        
        $interest = round($installment->interest +  $returned_interest, 2);
        $principal = round($installment->principal + $returned_principal, 2);

        $has_payment = $installment->succesfulRepayments->count() - 1 > 0;

        return $installment->update([
            'interest' => $interest,
            'principal' => $principal,
            'has_payment'=>$has_payment,
        ]);

        // return $installment->refreshInstallment();

    }
    
}
