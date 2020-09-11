<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $hidden = array('pivot');

    protected $fillable = [
        'name',
        'automated',
        'calculation_type',
        'gl_account',
        'fixed_amount'
    ];

    
    public function loan(){
        return $this->belongsToMany(Loan::class,'loan_fee');
    }

    public function calculateFeeAmount($loan_amount,$installment,$loan_product){
        
        //cgli premium ok
        //cgli fee ok
        //dst ok
        $weeks = 0;
        if($loan_product->installment_method=="weeks"){
            $weeks = $loan_product->installment_length * $installment;
        }
        if($loan_product->installment_method=="weeks"){
            
        }
        
        
        if($this->calculation_type=="fixed"){
           return $this->fixed_amount;
        }
        if ($this->calculation_type=="percentage") {
            return $loan_amount * (double) $this->percentage;
        }
        if ($this->calculation_type=="matrix") {
            if($this->name=="Documentary Stamp Tax"){
                $months = $this->weekToMonth($weeks);
                $days = $this->monthToDays($months);
                return round(($loan_amount/200) * ($days / 365) * 1.5, 2);
                
            }
            if($this->name=="MI Premium"){
                return 0;
            }
            if($this->name=="CGLI Fee"){
                $months = $this->weekToMonth($weeks);
                $monthly_rate = $this->cgliRateFromMonths($months);
                $cgli_premium_remittance = $loan_amount / 1000 * $monthly_rate;
                $cgli_premium_payable = $loan_amount * 0.005;
                $cgli_fee = $cgli_premium_payable - $cgli_premium_remittance ;
                return $cgli_fee;
                
            }
            if($this->name=="CGLI Premium"){
                $months = $this->weekToMonth($weeks);
                $monthly_rate = $this->cgliRateFromMonths($months);
                $cgli_premium_remittance = $loan_amount / 1000 * $monthly_rate;
                $cgli_premium_payable = $loan_amount * 0.005;
                return $cgli_premium_remittance;
                
            }
            if($this->name=="PHIC Premium"){
                return 0;
            }
        }

        Log::critical('Fee name non existing: '.$this);

    }

    public function weekToMonth($number_of_weeks){
        return (int) round($number_of_weeks / 4);
    }
    public function monthToDays($months){
        if($months == 12){
            return 365;
        }
        return $months * 30;
    }
    public function cgliRateFromMonths($months){
        if($months == 8){
            return 3.65;
        }
        if($months == 9){
            return 4.1;
        }
        if($months == 10){
            return 4.5;
        }
        if($months == 11){
            return 4.75;
        }
        if($months == 12){
            return 4.85;
        }
        return 0.45;
    }
    

    
}
