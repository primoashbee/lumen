<?php

namespace App;

use App\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

class DefaultPaymentMethod extends Model
{
    protected $appends = [
        'disbursement',
        'repayment',
        'deposit',
        'withdrawal',
        'recovery',
    ];
    protected $fillable = [
                'office_id',
                'disbursement_payment_method_id',
                'repayment_payment_method_id',
                'deposit_payment_method_id',
                'withdrawal_payment_method_id',
                'recovery_payment_method_id'
            ];
    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getDisbursementAttribute(){
        return PaymentMethod::find($this->disbursement_payment_method_id);
    }
    public function getRepaymentAttribute(){
        return PaymentMethod::find($this->repayment_payment_method_id);
    }
    public function getDepositAttribute(){
        return PaymentMethod::find($this->deposit_payment_method_id);
    }
    public function getWithdrawalAttribute(){
        return PaymentMethod::find($this->withdrawal_payment_method_id);
    }
    public function getRecoveryAttribute(){
        return PaymentMethod::find($this->recovery_payment_method_id);
    }
}
