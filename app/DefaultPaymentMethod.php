<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultPaymentMethod extends Model
{
    protected $fillable = [
                'office_id',
                'disbursement_payment_method_id',
                'repayment_payment_method_id',
                'deposit_payment_method_id',
                'withdrawal_payment_method_id',
                'recovery_payment_method_id'
            ];
        
}
