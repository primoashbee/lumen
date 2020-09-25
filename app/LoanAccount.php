<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    protected $fillable=[
        'client_id',
        'loan_id',
        'amount',
        'principal',
        'interest',
        'interest_rate',
        'number_of_installments',

        'total_deductions',
        'disbursed_amount', //net disbursement
        
        'approved_by',
        'approved',
        'approved_at',

        'disbursed_by',
        'disbursed_at',
        'disbursed',

        'first_payment',
        'last_payment',

        'created_by',
        'created_at',

        'notes'

    ];

    public function product(){
        return $this->belongsTo(Loan::class,'loan_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function schedules(){
        
        if($this->product->id == 1){
            
            $rate = $this->rate/4;
            $amount = $this->amount;
            $weeks =  $this->number_of_installments;
            $annual_rate = 0.03 * 12;
        
            $loan_info = $this->calculate($amount,$annual_rate,$this->interest_rate,$this->product->nterest_interval,$this->product->installment_method,$this->number_of_installments);
            return $loan_info;
        }

    }

    public static function calculate($principal,$annual_rate,$interest_rate,$interest_interval,$term,$term_length){
        $interval = 0;
        if($interest_interval=='Monthly'){
            $interval = 4;
        }
        if ($term == 'weeks') {
            $number_of_weeks = 52;
            $exponent = $number_of_weeks*($term_length/$number_of_weeks);
            $base = 1+($annual_rate/$number_of_weeks);
            
            
            $total_amount = $principal * pow($base,$exponent);
            $total_interest = $total_amount - $principal;
            
            $amortization = $total_amount / $term_length;

            $principal_balance = $principal;
            $installments = array();
            
            $weekly_compounding_rate = ($interest_rate / 4) / 100;
            $interest_balance = round($total_interest,2);
            for ($x=0;$x<=$term_length;$x++) {
                if ($x == 0) {
                    $interest = 0;
                    $principal = 0;
                    $installments[] = (object)array(
                    'installment'=>$x,
                    'principal_balance'=>$principal_balance,
                    'interest'=>$interest,
                    'interest_balance'=>$interest_balance,
                    'principal'=>$principal,
                    'amortization'=>$principal + $interest,

                );
                    $principal_balance = $principal_balance - $principal;
                    $interest_balance = $interest_balance - $interest;
                }elseif($x==$term_length){
                    $principal = $installments[$x-1]->principal_balance;
                    $interest = $installments[$x-1]->interest_balance;
                    
                    $principal_balance = $installments[$x-1]->principal_balance - $principal;
                    $interest_balance = $installments[$x-1]->interest_balance - $interest;
                    
                    $installments[] = (object)array(
                    'installment'=>$x,
                    'principal_balance'=>$principal_balance,
                    'interest'=>$interest,
                    'principal'=>$principal,
                    'interest_balance'=>$interest_balance,
                    'amortization'=>$principal + $interest,

                );
                    $principal_balance = $principal_balance - $principal;
                }else{
                    $interest = round($principal_balance * $weekly_compounding_rate, 2);
                    $principal = round($amortization - $interest, 2);
                    
                    $principal_balance = round($principal_balance - $principal,2);
                    $interest_balance = round($interest_balance - $interest,2);

                    $installments[] = (object)array(
                    'installment'=>$x,
                    'principal_balance'=>$principal_balance,
                    'interest'=>$interest,
                    'principal'=>$principal,
                    'interest_balance'=>$interest_balance,
                    'amortization'=>$principal + $interest,

                );
                    
                }

                
            }

        
            return collect($installments);

            
        }
    }

}
