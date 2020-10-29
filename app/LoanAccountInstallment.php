<?php

namespace App;

use App\Traits\MoneyMutator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LoanAccountInstallment extends Model
{
    
    protected $fillable = [
        'loan_account_id',
        'installment',
        'date',
        'original_principal',
        'original_interest',
        'principal',
        'interest',
        'principal_due',
        'interest_due',
        'amount_due',
        'amortization',
        'paid', 
        'carried_over_amount',
        'principal_balance',
        'interest_balance',
        'waived_interest'
    ];

    protected $for_mutation  = [
        'original_principal',
        'original_interest',
        'principal',
        'interest',
        'principal_due',
        'interest_due',
        'amount_due',
        'amortization',
        'carried_over_amount',
        'principal_balance',
        'interest_balance'
    ];

    protected $dates = ['date','created_at','updated_at'];
    protected $appends = ['is_due','interest_paid','principal_paid','mutated'];
    public function repayments(){
        return $this->hasMany(LoanAccountInstallmentRepayment::class);
    }

    public function calculatePayment($amount,$user_id,$payment_method_id){
        
        
        $amount_due = $this->amount_due;
        $is_due = $this->isDue();
        $paid = false;
        if($amount >= $amount_due){
            $paid = true;
        }
        //check if installment is due
        if($is_due){
        //if installment has due then check amount vs amount due
            if($amount >= $amount_due){
                $interest_paid = $this->interest_due;
                $principal_paid = $this->principal_due;
                $amount_paid = round($interest_paid + $principal_paid,2);

                return [
                    'interest_paid'=>$interest_paid,
                    'principal_paid'=>$principal_paid,
                    'amount_paid'=> $amount_paid,
                    'carried_over_amount' => round($amount-$amount_paid,2),
                    'paid'=>$paid
                ];
            //pay only what can be payed
            }elseif($amount < $amount_due){
            
                //can pay the whole interest and some principal due
                if($amount > $this->interest_due){
                    $interest_paid = $this->interest_due;
                    $principal_paid = round($amount-$interest_paid,2);
                    $amount_paid = round($interest_paid + $principal_paid,2);
                    return [
                        'interest_paid'=>$interest_paid,
                        'principal_paid'=>$principal_paid,
                        'amount_paid'=> $amount_paid,
                        'carried_over_amount' => round($amount-$amount_paid,2),
                        'paid'=>$paid
                    ];
                }elseif($amount < $this->interest_due){
                    $interest_paid = $amount;
                    $principal_paid = 0;
                    $amount_paid = round($interest_paid + $principal_paid,2);
                    return [
                        'interest_paid'=>$amount,
                        'principal_paid'=>0,
                        'amount_paid'=> $amount,
                        'carried_over_amount' =>  $amount_paid,
                        'paid'=>$paid
                    ];
                }
            }
        }else{
            $amortized_interest = $this->interest;
            $amortized_principal = $this->principal;
            $amortization  = round($amortized_interest + $amortized_principal,2);

            if($amount >= $amortization){
                $interest_paid = $this->interest;
                $principal_paid = $this->principal;
                $amount_paid = round($interest_paid + $principal_paid,2);
                return [
                    'interest_paid'=>$interest_paid,
                    'principal_paid'=>$principal_paid,
                    'amount_paid'=> $amount_paid,
                    'carried_over_amount' => round($amount-$amount_paid,2),
                    'paid'=>true
                ];
            }elseif($amount < $amortization){
                //can pay the whole interest and some principal due
                if($amount >= $amortized_interest){
                    $interest_paid = $amortized_interest;
                    $principal_paid = round($amount-$interest_paid,2);
                    $amount_paid = round($interest_paid + $principal_paid,2);
                    return [
                        'interest_paid'=>$interest_paid,
                        'principal_paid'=>$principal_paid,
                        'amount_paid'=> $amount_paid,
                        'carried_over_amount' => round($amount-$amount_paid,2),
                        'paid'=> false
                    ];
                }elseif($amount < $amortized_interest){
                    $interest_paid = $amount;
                    $principal_paid = 0;
                    $amount_paid = round($interest_paid + $principal_paid,2);
                    return [
                        'interest_paid'=>$amount,
                        'principal_paid'=>0,
                        'amount_paid'=> $amount,
                        'carried_over_amount' =>  $amount_paid,
                        'paid'=>false
                    ];
                }
            }
        }
        
    }

    public function isDue(){
        
        return $this->date <= Carbon::now() && $this->paid == 0;
    }

    
    public function getIsDueAttribute(){
        return $this->date <= Carbon::now() && $this->paid == 0;
    }
    public function getInterestPaidAttribute(){
        if($this->paid){
            return $this->original_interest;
        }
        return abs(round($this->interest - $this->original_interest,2));
    }
    public function getPrincipalPaidAttribute(){
        if($this->paid){
            return $this->original_principal;
        }
        return abs(round($this->principal - $this->original_principal,2));
    }

    public function getMutatedAttribute(){
        $fields = $this->for_mutation;
        
        foreach($fields as $field){
            $attribute = $field;
            $mutated[$attribute] = env('CURRENCY_SIGN') . ' ' . number_format($this->$field,2);
        }
        $interest_paid =$this->original_interest;
        $principal_paid =$this->original_principal;
        if(!$this->paid){
            $interest_paid = abs(round($this->interest - $this->original_interest,2));    
            $principal_paid = abs(round($this->principal - $this->original_principal,2));
        }
        
        
        $mutated['interest_paid'] = env('CURRENCY_SIGN') . ' ' . number_format($interest_paid,2);
        $mutated['principal_paid'] = env('CURRENCY_SIGN') . ' ' . number_format($principal_paid,2);
        
        return $mutated;
        
    }
    
    public function reset(){
        if($this->date->diffInDays(Carbon::now()) < 0){
            $this->update([
                'principal_due' => $this->original_principal,
                'interest_due' => $this->original_interest,
                'paid'=>false,
                'carried_over_amount'=>0,
                'amount_due'=> round($this->original_principal + $this->original_interest,2),
                'amortization'=> round($this->original_principal + $this->original_interest,2),
                'waived_interest'=>false
                ]);
        }else{
            $this->update([
                'principal_due' => $this->original_principal,
                'principal' => $this->original_principal,
                'interest' => $this->original_interest,
                'interest_due' => 0,
                'carried_over_amount'=>0,
                'amortization'=> round($this->original_principal + $this->original_interest,2),
                'waived_interest'=>false,
                'paid'=>false,
                ]);
        }
    }

    public function waiveInterest(){
        $interest  = $this->interest;
        $amount_due = round($this->amount_due - $interest,2);
        return $this->update([
            'interest'=>0,
            'interest_due'=>0,
            'amount_due'=>$amount_due,
            'amortization'=>$amount_due,
            'waived_interest'=>true
            ]);
    }


}
