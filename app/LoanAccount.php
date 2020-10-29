<?php

namespace App;

use stdClass;
use App\Scheduler;
use Carbon\Carbon;
use App\LoanInstallment;
use App\LoanAccountFeePayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LoanAccount extends Model
{

    protected $pre_term_percentage = 0.5; // of total_interest
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
        
        'total_balance',
        'principal_balance',
        'interest_balance',

        'approved_by',
        'approved',
        'approved_at',

        'disbursed_by',
        'disbursed_at',
        'disbursed',

        'disbursement_date',
        'first_payment_date',
        'last_payment_date',

        'closed_at',

        'created_by',
        'created_at',

        'notes',
        'status'

    ];
    protected $appends = [
        'is_active',
        'amount_due'
    ];

    public function product(){
        return $this->belongsTo(Loan::class,'loan_id','id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    
    public function schedules(){
        
        if($this->product->id == 1){
            
            $rate = $this->rate/4;
            $amount = $this->amount;
            $weeks =  $this->number_of_installments;
            $annual_rate = 0.03 * 12;

            

            $loan_info = $this->calculate([$amount,$annual_rate,$this->interest_rate,$this->product->nterest_interval,$this->product->installment_method,$this->number_of_installments,'x']);
            return $loan_info;
        }

    }

    // public static function calculate($principal,$annual_rate,$interest_rate,$interest_interval,$term,$term_length,$start_date=null,$office_id){
    public static function calculate(array $data){
        $interval = 0;
        if($data['interest_interval']=='Monthly'){
            $interval = 4;
        }
        if ($data['term'] == 'weeks') {

            $number_of_weeks = 52;
            $term_length = $data['term_length'];
            $exponent = $number_of_weeks*($term_length/$number_of_weeks);
            
            $base = 1+($data['annual_rate']/$number_of_weeks);
            
            $principal = $data['principal'];
            $total_amount = $principal * pow($base,$exponent);
            
            $total_interest = round($total_amount - $principal,2);
            
            $amortization = $total_amount / $term_length;

            $principal_balance = $principal;
            $installments = array();

            $interest_rate = $data['interest_rate'];
            $weekly_compounding_rate = ($interest_rate / 4) / 100;
            
           
            $interest_balance = round($total_interest,2);

            // $sched = new Scheduler($start_date,$office_id);
            $office_id = $data['office_id'];
            $start_date = Scheduler::getDate($data['start_date'],$office_id);
            $current_date = Carbon::now();
            $end_date;
            $late = false;
            $date = 'now';
            for ($x=0;$x<=$term_length;$x++) {
                
                //first row
                if ($x == 0) {
                    $interest = 0;
                    $principal = 0;
                    $installments[] = (object)array(
                        'installment'=>$x,
                        'date'=>"----",
                        'principal_balance'=>$principal_balance,
                        'interest'=>$interest,
                        'interest_balance'=>$interest_balance,
                        'principal'=>$principal,
                        'amortization'=>$principal + $interest,

                        'formatted_principal_balance'=>money($principal_balance,2),
                        'formatted_interest'=>money($interest,2),
                        'formatted_interest_balance'=>money($interest_balance,2),
                        'formatted_principal'=>money($principal,2),
                        'formatted_amortization'=>money($principal + $interest,2)

                    );
                    $principal_balance = round($principal_balance - $principal,2);
                    $interest_balance = round($interest_balance - $interest,2);

                //last row
                }elseif($x==$term_length){
                    $principal = $installments[$x-1]->principal_balance;
                    $interest = $installments[$x-1]->interest_balance;
                    
                    $principal_balance = $installments[$x-1]->principal_balance - $principal;
                    $interest_balance = $installments[$x-1]->interest_balance - $interest;
                    $amortization = $interest + $principal;
                    
                    
                    $previous_installment_date  = Carbon::parse($installments[$x-1]->date);
                    $date = Scheduler::getDate($previous_installment_date->addWeek(),$office_id);
                    $late = false;
                    
                    $interest_due = 0;
                    $principal_due = 0;
                    $amount_due = 0;

                    if($late){
                        $interest_due = $interest;
                        $principal_due = $principal;
                        $amount_due = $interest + $principal;
                    }
                    

                    $installments[] = (object)array(
                        'installment'=>$x,
                        'date'=>$date,
                        'principal_balance'=>$principal_balance,
                        'interest'=>$interest,
                        'principal'=>$principal,
                        'interest_balance'=>$interest_balance,
                        'amortization'=>$amortization,
                        
                        'interest_due'=>$interest_due,
                        'principal_due'=>$principal_due,
                        'amount_due'=>$amount_due,
                        'formatted_amount_due'=>money($amount_due,2),

                        'formatted_principal_balance'=>money($principal_balance,2),
                        'formatted_interest'=>money($interest,2),
                        'formatted_interest_balance'=>money($interest_balance,2),
                        'formatted_principal'=>money($principal,2),
                        'formatted_amortization'=>money($amortization,2)

                    );
                    $principal_balance = $principal_balance - $principal;
                    $end_date = $date;

                //first payment
                }elseif($x==1){
                    $late = false;
                    if($start_date->lt($current_date)){
                        $late = true;
                    }
                    $interest = round($principal_balance * $weekly_compounding_rate,2);
                    $principal = round($amortization - $interest,2);
                    
                    $principal_balance = round($principal_balance - $principal,2);
                    $interest_balance =round($interest_balance - $interest,2);
                    $amortization = round($interest + $principal,2);

                    $interest_due = 0;
                    $principal_due = 0;
                    $amount_due = 0;
                    
                    if($late){
                        $interest_due = $interest;
                        $principal_due = $principal;
                        $amount_due = $interest + $principal;
                    }
                    $installments[] = (object)array(
                            'installment'=>$x,
                            'date'=>$start_date,
                            'principal_balance'=>$principal_balance,
                            
                            'interest'=>$interest,
                            'principal'=>$principal,
                            
                            'interest_due'=>$interest_due,
                            'principal_due'=>$principal_due,
                            'amount_due'=>$amount_due,

                            'interest_balance'=>$interest_balance,
                            'amortization'=>$amortization,
                            

                            'formatted_amount_due'=>money($amount_due,2),
                            'formatted_principal_balance'=>money($principal_balance,2),
                            'formatted_interest'=>money($interest,2),
                            'formatted_interest_balance'=>money($interest_balance,2),
                            'formatted_principal'=>money($principal,2),
                            'formatted_amortization'=>money($amortization,2)

                        );
                }else{

                    $previous_installment_date  = Carbon::parse($installments[$x-1]->date);
                    $date = Scheduler::getDate($previous_installment_date->addWeek(),$office_id);
                    $late = false;
                    if($date->lt($current_date)){
                        $late = true;
                    }
                    $interest = round($principal_balance * $weekly_compounding_rate,2);
                    $principal = round($amortization - $interest,2);
                    
                    $principal_balance = round($principal_balance - $principal,2);
                    $interest_balance = round($interest_balance - $interest,2);
                    $amortization = round($interest + $principal,2);

                    $interest_due = 0;
                    $principal_due = 0;
                    $amount_due = 0;
                    if($late){
                        $interest_due = $interest;
                        $principal_due = $principal;
                        $amount_due = $interest + $principal;
                    }

                    $installments[] = (object)array(
                            'installment'=>$x,
                            'date'=>$date,
                            'principal_balance'=>$principal_balance,
                            'interest'=>$interest,
                            'principal'=>$principal,
                            'interest_balance'=>$interest_balance,
                            'amortization'=>$amortization,

                            'interest_due'=>$interest_due,
                            'principal_due'=>$principal_due,
                            'amount_due'=>$amount_due,
                            
                            'formatted_amount_due'=>money($amount_due,2),
                            'formatted_principal_balance'=>money($principal_balance,2),
                            'formatted_interest'=>money($interest,2),
                            'formatted_interest_balance'=>money($interest_balance,2),
                            'formatted_principal'=>money($principal,2),
                            'formatted_amortization'=>money($amortization,2)

                        );
                    
                }
                

                

                
            }
            
            $disbursement_date = $data['disbursement_date'];

            $data = new stdClass;
            $data->installments = collect($installments);
            $data->total_interest = $total_interest;
            $data->disbursement_date = $disbursement_date;
            $data->start_date = $start_date;
            $data->end_date = $end_date;
            
            
            
            return $data;
            
        }
    }

    public function feePayments(){
        return $this->hasMany(LoanAccountFeePayment::class);
    }
    public function installments(){
        return $this->hasMany(LoanAccountInstallment::class);
    }

    public function unDueInstallments(){
        return $this->installments()->where('amount_due',0)->where('paid',0)->orderBy('installment','asc');
    }

    public function dueInstallments(){
        return $this->installments()
            // ->where('amount_due','>',0)
            ->where('paid',false)
            ->where('date','<=', Carbon::now())
            ->orderBy('installment','asc');
    }
    
    

    public function isActive(){
        $inactives = ['Pending Approval','Approved','Disapproved','Closed'];
        in_array($this->status,$inactives);
        return !in_array($this->status,$inactives);
    }

    //update balances from dues only
    public function updateBalances(){
        $interest_balance = round($this->interest - $this->totalPaid()->interest,2);
        $principal_balance = round($this->principal - $this->totalPaid()->principal,2);
        $total_balance = round($interest_balance + $principal_balance,2);
        return $this->update([
            'interest_balance'=>$interest_balance,
            'principal_balance'=>$principal_balance,
            'total_balance'=>$total_balance
        ]);
    }

    public function updateStatus(){
        if($this->total_balance==0){
            $this->status="Closed";
            $this->closed_at=Carbon::now();
            return $this->save();
        }
        if ($this->disbursed) {
            if ($this->hasDue()) {
                 $this->status = 'In Arrears';
                 return $this->save();
            }
            $this->status = 'Active';
            return $this->save();
        }
    }

    

    public function updateDueInstallments(){
        $installments = $this->installments->where('date','<=',Carbon::now());
        $total = $installments->count();
        $ctr = 0;
        foreach($installments as $item){
            $interest_due = $item->interest;
            $principal_due = $item->principal;
            $amount_due = $interest_due + $principal_due;
            $item->update([
                'interest_due'=>$interest_due,
                'principal_due'=>$principal_due,
                'amount_due'=>$amount_due,
            ]);
            $ctr++;
        }
        return $ctr  == $total;
    }
    
    public function repayments(){
        return $this->hasMany(LoanAccountRepayment::class)->orderBy('created_at','DESC');
    }

    public function allRepayments(){
        $fee_payments = collect($this->feePayments);
        $loan_repayments = collect($this->repayments->sortBy('created_at'));

        return $loan_repayments->merge($fee_payments)->sortByDesc('created_at');

    }

    public function outstandingBalance(){
        $principal = $this->installments->sum('principal_due');
        $interest = $this->installments->sum('interest_due');
        $total = $principal + $interest;
        return (object) ['principal'=>$principal,'interest'=>$interest,'total'=>$total];
    }

    public function preTermAmount(){
        $amortized_interest = $this->interest;
        $principal = $this->principal_balance;
        $total_paid = $this->totalPaid();
        $minimum_interest_to_be_paid = $amortized_interest / 2; //50%

        //if paid the qualified % of interest to be paid
        if($total_paid->interest >= $minimum_interest_to_be_paid){
           $interest = 0;
        }else if($total_paid->interest < $minimum_interest_to_be_paid){
            $interest = round($minimum_interest_to_be_paid - $total_paid->interest,2);
        }
        $total = round($interest + $principal,2);
    
    
        return (object) [
            'interest'=>$interest,
            'formatted_interest'=>money($interest,2),
            'principal'=>$principal,
            'formatted_principal'=>money($principal,2),
            'total'=>$total,
            'formatted_total'=>money($total,2)
        ];
    }

    public function amountDue(){
        $principal = $this->installments->where('date','<=',Carbon::now())->sum('principal_due');
        $interest = $this->installments->where('date','<=',Carbon::now())->sum('interest_due');
        $total = $principal + $interest;
        return (object) [
            'principal'=>$principal,
            'interest'=>$interest,
            'total'=>$total,
            'formatted_principal'=>money($principal,2),
            'formatted_interest'=>money($interest,2),
            'formatted_total'=>money($total,2)
        ];
    }

    public function hasDue(){
        if($this->amountDue()->total >0){
            return true;
        }
        return false;
    }
    public function totalPaid(){
        $principal =  $this->repayments()->sum('principal_paid');
        $interest =  $this->repayments()->sum('interest_paid');
        $total = $principal + $interest;
        return (object) ['principal'=>$principal,'interest'=>$interest,'total'=>$total];

    }

    public function getIsActiveAttribute(){
        return $this->isActive();
    }
    public function getAmountDueAttribute(){
        return $this->amountDue();
    }

    public function latestRepayment(){
        return $this->repayments->first();
    }

    public function generateRepaymentTransactionNumber(){
        
        //year + month + day + loan account number + micro
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;

        $mt = explode(' ', microtime());
        $microsecs = $mt[0];
        $secs = $mt[1];
        
        $loan_account_id = $this->id;
        
        
        // $length = strlen($secs);
        // $total = 0;
        // for($x=0;$x<=$length-1;$x++){
        //     $total+= (int) $secs[$x];
        // }
        
        $repayments = $this->repayments->count()+1;
        $last = str_pad($repayments,3,0,STR_PAD_LEFT);
        $transaction = 'R'.$year.$month.$day.$loan_account_id.$last;
        return $transaction;
    }
    


    public function reset(){
        $this->installments->each(function($item){
            $item->reset();
        });
        $this->repayments()->delete();

        $this->updateDueInstallments();
        $this->update([
            'interest_balance'=>$this->interest,
            'principal_balance'=>$this->principal,
            'total_balance'=>round($this->interest+$this->principal,2)
        ]);
    }

    public function pay(array $data){
        $payment_amount = round($data['amount'],2);
        $amount_due = $this->amountDue();
        $paid_by = $data['paid_by'];
        $payment_method_id = $data['payment_method'];
        $repayment_date = $data['repayment_date'];
        $notes = $data['notes'];

        $interest_paid = 0;
        $principal_paid = 0;
        // if($payment_amount == $this->maximumPayment()->amount){
        
        // }
        //acount has due installments 
        if($amount_due->total > 0){
            $installments = $this->dueInstallments;
            //if amount paid can do advanced payment
            if($payment_amount > $installments->sum('amount_due')){
                    $installments = collect($installments)->merge(collect($this->unDueInstallments));
            }
        //if advanced payments
        }else{
            $installments = $this->unDueInstallments;
        }


        
        $for_payment = $payment_amount; //for decrementals
        foreach($installments as $installment){
            $info = $installment->calculatePayment($for_payment,$paid_by, $payment_method_id);
            $for_payment = round($for_payment - $info['amount_paid'],2);
            $interest_paid = round($interest_paid + $info['interest_paid'],2);
            $principal_paid = round($principal_paid + $info['principal_paid'],2);
            if($installment->isDue()){
                $amount_due = $installment->amount_due;
                $new_interest_due  = round($installment->interest_due - $info['interest_paid'],2); 
                $new_principal_due = round($installment->principal_due - $info['principal_paid'],2);

                $new_amount_due = round(($new_interest_due+ $new_principal_due),2);
                $installment->update([
                    'interest_due'=>$new_interest_due,
                    'principal_due'=>$new_principal_due,
                    'amount_due'=> $new_amount_due,
                    'carried_over_amount'=>$info['carried_over_amount'],
                    'paid'=>$info['paid'] 
                ]);
            }else{
                $new_installment_interest = round($installment->interest - $info['interest_paid'],2);
                $new_installment_principal = round($installment->principal - $info['principal_paid'],2);
                $new_installment_amortization = $new_installment_interest + $new_installment_principal;
                $installment->update([
                    'interest'=>$new_installment_interest,
                    'principal'=>$new_installment_principal,
                    'principal_due'=>$new_installment_principal,
                    'amortization'=>$new_installment_amortization,
                    'carried_over_amount'=>$info['carried_over_amount'],
                    'paid'=>$info['paid']
                ]);
            }

            if($for_payment <= 0){
                break;
            }
        }

        return $this->repayments()->create([
            'transaction_id'=>$this->generateRepaymentTransactionNumber(),
            'interest_paid'=>$interest_paid,
            'principal_paid'=>$principal_paid,
            'total_paid'=>$payment_amount,
            'paid_by'=>$paid_by,
            'payment_method_id'=>$payment_method_id,
            'repayment_date'=>$repayment_date,
            'notes'=>$notes
        ]);
    }

    public function maximumPayment(){ 
        
       return (object) [
           'amount'=>$this->total_balance,
           'formatted_amount'=>money($this->total_balance,2)
        ];
    }

    public function fullPay(){
        $installments = $this->dueInstallments;
    }

    public function updateAccount(){
        $this->updateBalances();
        $this->updateStatus();
        
    }

    public function preTerminate(array $data){

        $total_paid = $this->totalPaid();
        $amount = $this->preTermAmount();

        $this->installments->each(function($installment){
            $installment->update([
                'paid'=>true
            ]);
        });

        $this->repayments()->create([
            'transaction_id'=>$this->generateRepaymentTransactionNumber(),
            'interest_paid'=>$amount->interest,
            'principal_paid'=>$amount->principal,
            'total_paid'=>$amount->total,
            'paid_by'=>$data['paid_by'],
            'payment_method_id'=>$data['payment_method'],
            'repayment_date'=>$data['repayment_date'],
            'for_pretermination'=>1,
            'notes'=>$data['notes']
        ]);
        $this->interest_balance = 0;
        $this->principal_balance = 0;
        $this->total_balance = 0;
        $this->save();
        return $this->updateStatus();
    }

    
}
