<?php

namespace App;

use App\Fee;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LoanAccountFeePayment extends Model
{
    protected $fillable = [
        'loan_account_id',
        'transaction_id',
        'fee_id',
        'amount',
        'payment_method_id',
        'paid_at',
        'paid_by',
    ];
    
    protected $table='loan_account_fee_payments';
    protected $appends = ['mutated'];
    

    public function fee(){
        return $this->belongsTo(Fee::class,'fee_id');
    }
    public function loanAccount(){
        return $this->belongsTo(LoanAccount::class, 'loan_account_id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }
    public function paidBy(){
        return $this->belongsTo(User::class,'paid_by');
    }
    
    public function getMutatedAttribute(){
        $mutated['total_paid'] = env('CURRENCY_SIGN') . ' ' . number_format($this->amount,2);
        $mutated['paid_by'] = $this->paidBy->fullname;
        $mutated['payment_method'] = $this->paymentMethod->name;
        $mutated['particulars'] = $this->fee->name;
        return $mutated;   
    }

    public function generateTransactionID($add){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;

        $mt = explode(' ', microtime());
        $microsecs = $mt[0];
        $secs = $mt[1];
        
        $loan_account_id = $this->loan_account_id;
        
        
        // $length = strlen($secs);
        // $total = 0;
        // for($x=0;$x<=$length-1;$x++){
        //     $total+= (int) $secs[$x];
        // }
        
        $repayments = LoanAccountFeePayment::count()+$add;
        $last = str_pad($repayments,3,0,STR_PAD_LEFT);
        $transaction = 'F'.$year.$month.$day.$loan_account_id.$last;
        return $transaction;
    }
}
