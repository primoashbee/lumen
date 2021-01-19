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
        'total_loan_amount',
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


        'disbursed_at',
        'disbursed',

        'disbursement_date',
        'first_payment_date',
        'last_payment_date',
        

        'closed_at',
        'closed_by',

        'created_by',
        'created_at',

        'notes',
        'status'

    ];
    protected $appends = [
        'is_active',
        'amount_due'
    ];

    protected $dates = [
        'created_at',
        'disbursed_at',
        'approved_at',
        'disbursement_date',
        'first_payment_date',
        'last_payment_date',
        'created_at',
        'updated_at'
    ];

    protected $for_mutation =['amount','principal','interest','disbursed_amount','total_balance','interest_balance','principal_balance','total_deductions','disbursed_amount'];

    public static function active(){
        
        return LoanAccount::whereNull('closed_at')->get();
    }
    public function disbursement(){
        return $this->hasMany(LoanAccountDisbursement::class);
    }
    public function product(){
        return $this->belongsTo(Loan::class,'loan_id','id');
    }

    public function client(){
        return Client::fcid($this->client_id);
        // return $this->hasOne(Client::class,'client_id','client_id');
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
            // $end_date;
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

                    
                    $interest_due = 0;
                    $principal_due = 0;
                    $amount_due = 0;
                    
                    $late = false;
                    if($date->lt($current_date)){
                        $late = true;
                    }
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
            $total_loan_amount =  round($data['principal'] + $total_interest,2);
            $data = new stdClass;
            $data->installments = collect($installments);
            $data->total_interest = $total_interest;
            $data->total_loan_amount = $total_loan_amount;
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
    public function dependents(){
        return $this->hasOne(Dependent::class);
    }
    public function unDueInstallments(){
        return $this->installments()->where('paid',0)->orderBy('installment','asc');
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
    public function successfulRepayments(){
        return $this->hasMany(LoanAccountRepayment::class)->where('reverted',false)->orderBy('created_at','DESC');
    }

    public function allRepayments(){
        $fee_payments = collect($this->feePayments);
        $loan_repayments = collect($this->successfulRepayments->sortBy('created_at'));

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
        $amount_due = $this->amountDue();
        if($amount_due->interest > 0){
            $interest = $amount_due->interest;
            $total = round($interest + $principal,2);
        }
    
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
        $principal = $this->installments->where('paid',false)->where('date','<=',Carbon::now())->sum('principal_due');
        $interest = $this->installments->where('paid',false)->where('date','<=',Carbon::now())->sum('interest_due');
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
        $principal =  $this->successfulRepayments->sum('principal_paid');
        $interest =  $this->successfulRepayments->sum('interest_paid');
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
        return $this->successfulRepayments->first();
    }

    public function generateRepaymentTransactionNumber($type=null){
        
        //year + month + day + loan account number + micro
        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');

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
        if($type=='ctlp'){
            $transaction = 'C'.$year.$month.$day.$loan_account_id.$last;
        }
        if($type=='pretermination'){
            $transaction = 'P'.$year.$month.$day.$loan_account_id.$last;
        }
        
        return $transaction;
    }


    public function updateStatus($user_id=null){
        $amount_due = $this->amountDue();
        if($amount_due->total > 0){
            return $this->update([
                'status'=>'In Arrears'
            ]);
        }
        if($amount_due->total == 0){
            return $this->update([
                'status'=>'Active'
            ]);
        }
        if($this->total_balance == 0){
            return $this->update([
                'status'=>'Closed'
            ]);
        }
        
       
    }
    
    public function closeAccount($paid_by){
        return $this->update([
            'closed_at'=>Carbon::now(),
            'closed_by'=>$paid_by
        ]);
    }
    
    public function generateDisbursementTransactionNumber(){
        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');

        $mt = explode(' ', microtime());
        $microsecs = $mt[0];
        $secs = $mt[1];
        
        $loan_account_id = $this->id;
        
        
        // $length = strlen($secs);
        // $total = 0;
        // for($x=0;$x<=$length-1;$x++){
        //     $total+= (int) $secs[$x];
        // }
        
        $disbursements = $this->disbursement->count()+1;
        $last = str_pad($disbursements,3,0,STR_PAD_LEFT);
        $transaction = 'D'.$year.$month.$day.$loan_account_id.$last;
        return $transaction;
    }

    public function reset(){
        $this->installments->each(function($item){
            $item->reset();
            $item->repayments()->delete();
        });
        $this->repayments()->delete();
        
        $this->updateDueInstallments();
        $this->update([
            'interest_balance'=>$this->interest,
            'principal_balance'=>$this->principal,
            'total_balance'=>round($this->interest+$this->principal,2),
            'closed_by'=>null,
            'closed_at'=>null
        ]);
        $this->updateStatus();
       
    }

    public function updateBalancesAfterPayment($interest_paid,$principal_paid){
        return $this->update([
            'interest_balance'=>round($this->interest_balance - $interest_paid),
            'principal_balance'=>round($this->principal_balance - $principal_paid),
            'total_balance'=>round($this->total_balance - ($interest_paid + $principal_paid),2)
        ]);
    }
    public function pay(array $data){
        $payment_amount = round($data['amount'],2);
        $amount_due = $this->amountDue();
        $paid_by = $data['paid_by'];
        $payment_method_id = $data['payment_method'];
        $repayment_date = $data['repayment_date'];
        $notes = $data['notes'];
        
        $method = PaymentMethod::find($data['payment_method']);
        $transaction_number= $this->generateRepaymentTransactionNumber();
       
        \DB::beginTransaction();

        try{
             if($method->isCTLP()){
                $this->client->ctlpAccount()->payCTLP($data); 
                $transaction_number = $this->generateRepaymentTransactionNumber('ctlp');
            }
        
            $repayment = $this->remainingInstallments()->first()->pay($payment_amount,$transaction_number,$paid_by);
            $this->repayments()->create([
                'transaction_id'=>$transaction_number,
                'interest_paid'=>$repayment->interest,
                'principal_paid'=>$repayment->principal,
                'total_paid'=> round($repayment->interest + $repayment->principal,2),
                'paid_by'=>$paid_by,
                'payment_method_id'=>$payment_method_id,
                'repayment_date'=>$repayment_date,
                'notes'=>$notes
            ]);
            
            $this->fresh()->updateBalancesAfterPayment($repayment->interest,$repayment->principal);
            if($this->total_balance == 0){
                $this->closeAccount($paid_by);
            }
            $this->fresh()->updateStatus();
            \DB::commit();
           
        }catch(\Execption $e){
            return $e->getMessage();
        }
        
       
    }

    public function updateBalances(){
        $interest_paid = $this->totalPaid()->interest;
        $principal_paid = $this->totalPaid()->principal;
        $total_paid = $this->totalPaid()->total;

        return $this->update([
            'interest_balance'=>round($this->interest  - $interest_paid ,2),
            'principal_balance'=>round($this->principal  - $principal_paid ,2),
            'total_balance'=>round($this->total_loan_amount  - $total_paid ,2),
        ]);
    }

    public function ctlp(array $data){
        $payment_amount = round($data['amount'],2);
        $amount_due = $this->amountDue();
        $paid_by = $data['paid_by'];
        $payment_method_id = $data['payment_method'];
        $repayment_date = $data['repayment_date'];
        $notes = $data['notes'];

        $this->client->ctlpAccount()->payCTLP($data); 
        $transaction_number = $this->generateRepaymentTransactionNumber('ctlp');
        \DB::beginTransaction();

        try{
            $repayment = $this->remainingInstallments()->first()->pay($payment_amount,$transaction_number);
            \DB::commit();
        }catch(\Execption $e){
            return $e->getMessage();
        }
    }

    
    public function maximumPayment(){ 
        
       return (object) [
           'amount'=>$this->total_balance,
           'formatted_amount'=>money($this->total_balance,2)
        ];
    }
    
    public function preTerminate(array $data){

        $amount = $this->preTermAmount();
        $transaction_id = $this->generateRepaymentTransactionNumber('pretermination');
        $preterm_interest = $amount->interest;
        $preterm_principal = $amount->principal;
        $paid_by = $data['paid_by'];
        $payment_method_id = $data['payment_method'];
        $repayment_date = $data['repayment_date'];
        $notes = $data['notes'];
        
        $method = PaymentMethod::find($data['payment_method']);
        if($method->isCTLP()){
            $this->client->ctlpAccount()->payCTLP($data); 
        }
        
        $installments = $this->remainingInstallments();
        $interest_paid = 0;
        $principal_paid = 0;
        foreach($installments as $installment){
            $is_due = $installment->isDue();
            $interest = $installment->interest;
            $principal = $installment->principal_due;

            if($preterm_interest < $interest){
                $interest = $preterm_interest;
                $preterm_interest = 0;
                
            }
            if($is_due){
                $interest = $installment->interest_due;
            }

            if ($preterm_interest > $interest) {
                $preterm_interest = round($preterm_interest - $interest, 2);
            }

            $preterm_principal = round($preterm_principal - $principal,2);

            if($is_due){
                $installment->update([
                    'interest_due'=>round($installment->interest_due - $interest,2),
                    'interest'=>0,
                    'principal_due'=>round($installment->principal_due - $principal,2),
                    'amount_due'=>0,
                    'paid'=>true
                ]);
            }else{
                $installment->update([
                    'interest'=>round($installment->interest - $interest,2),
                    'principal_due'=>round($installment->principal_due - $principal,2),
                    'paid'=>true
                ]);
            }
            $installment->repayments()->create([
                'interest_paid'=>$interest,
                'principal_paid'=>$principal,
                'total_paid'=>round($interest + $principal,2),
                'transaction_id'=>$transaction_id,
                'paid_by'=>$paid_by,
            ]);

        }

 
        
    

        $this->repayments()->create([
            'transaction_id'=>$transaction_id,
            'interest_paid'=>$amount->interest,
            'principal_paid'=>$amount->principal,
            'total_paid'=>$amount->total,
            'payment_method_id'=>$payment_method_id,
            'paid_by'=>$paid_by,
            'for_pretermination'=>true,
            'repayment_date'=>$repayment_date,
            'notes'=>$notes
        ]);

        return $this->update([
            'status'=>'Closed',
            'closed_at'=>Carbon::now(),
            'closed_by'=>$paid_by,
            'principal_balance'=>0,
            'interest_balance'=>0,
            'total_balance'=>0,
        ]);
    }


    public function remainingInstallments(){
        $due_installments = collect($this->dueInstallments);
        $undue_installments = collect($this->unDueInstallments);

        return $due_installments->merge($undue_installments)->unique();
    
    }
    
    public function activity(){
        
        $repayments = $this->repayments;
        $fees = $this->feePayments;
        $disbursements = $this->disbursement;
        
        // dd($disbursements->sortBy('id'));
        // return $repayment_date->merge($fees->merge($disbursements));
        return $repayments->toBase()->merge($fees->toBase()->merge($disbursements));
    }

    public function canRevertDisbursement($transaction_id){
        if(LoanAccountDisbursement::where('transaction_id',$transaction_id)->first()->reverted){
            return false;
        }
        $succesful_transactions = $this->successfulRepayments->count();
        return $succesful_transactions > 0 ? false : true;
    }

    public function revertDisbursement($transaction_id,$user_id){
        $disbursement = LoanAccountDisbursement::where('transaction_id',$transaction_id)->first();
        $disbursement->revert($user_id);

        return $this->update([
            'disbursed_by'=>null,
            'disbursed_at'=>null,
            'disbursed'=>false,
            'status'=>'Pending Approval'
        ]);
    }

    public function getMutatedAttribute(){
        $fields = $this->for_mutation;
        
        foreach($fields as $field){
            $attribute = $field;
            $mutated[$attribute] = env('CURRENCY_SIGN') . ' ' . number_format($this->$field,2);
        }
        

        return $mutated;
    }

    public function getTotalPaidAttribute(){
        $paid = $this->totalPaid();
        $payment['interest'] = $paid->interest;
        $payment['principal'] = $paid->principal;
        $payment['total'] = $paid->total;
        
        $payment['formatted_interest'] = env('CURRENCY_SIGN') . ' ' . number_format($paid->interest,2);
        $payment['formatted_principal'] = env('CURRENCY_SIGN') . ' ' . number_format($paid->principal,2);
        $payment['formatted_total'] = env('CURRENCY_SIGN') . ' ' . number_format($paid->total,2);
        
        return $payment;
    }

    public function getPreTermAmountAttribute(){
        return $this->preTermAmount();
    }

    public function getActivityAttribute(){
        return $this->activity();
    }

    public function getClientAttribute(){
        return $this->client();
    }
    
    public function getBasicClientAttribute(){
        return Client::select('firstname','middlename','lastname')->where('client_id',$this->client_id)->first();
    }
    public function canBeApproved(){
        if(is_null($this->approved_by) && is_null($this->approved_at) && $this->approved == false){
            return true;
        }

        return false;
    }

    public function approve($user_id){
        $this->update([
            'approved_by'=>$user_id,
            'approved_at'=>Carbon::now(),
            'status'=>'Approved',
            'approved'=>true
        ]);
    }

    public function disburse(array $payment_info){
        $account = $this;
        $fee_payments = $account->feePayments;
        $payment_method_id = $payment_info['payment_method_id'];
        $disbursed_by = $payment_info['disbursed_by'];
        \DB::beginTransaction();
      
        try{
            $transaction_id = $account->generateDisbursementTransactionNumber();
            
            
            $account->payFeePayments($fee_payments,$payment_method_id,$disbursed_by,$transaction_id);
            
            $disbursement_date = Carbon::parse($payment_info['disbursement_date']);
            $start_date = Carbon::parse($payment_info['first_repayment_date']);
            $office_id = $payment_info['office_id'];
            if($this->disbursement_date->diffInDays($disbursement_date,false) > 0){
               $this->disbursement_date = $disbursement_date;
               $this->save();
            }

            //first payment is not the same as created payment
            if($this->installments->first()->date->diffInDays($disbursement_date,false) > 0){
                //create new installments
                $this->installments()->delete();
                $annual_rate = 0.03 * 12;
                $product = $this->product;
                $data = array(
                    'principal'=>$this->amount,
                    'annual_rate'=>$annual_rate,
                    'interest_rate'=>$product->interest_rate,
                    'interest_interval'=>$product->interest_interval,
                    'term'=>$product->installment_method,
                    'term_length'=>$this->number_of_installments,
                    'disbursement_date'=>$disbursement_date,
                    'start_date'=>$start_date,
                    'office_id'=>$office_id
                );
                $calculator = LoanAccount::calculate($data);
                $this->createInstallments($this,$calculator->installments);
            }

            
            $account->update([
                'disbursed_at'=>Carbon::now(),
                'disbursed_by'=>$disbursed_by,
                'status'=>'Active',
                'disbursed'=>true
            ]);
            
            $account->disbursement()->create([
                'transaction_id'=>$transaction_id,
                'disbursed_amount'=>$account->disbursed_amount,
                'disbursed_by'=>auth()->user()->id,
                'payment_method_id'=>$payment_method_id 
            ]);
            
            $account->updateStatus();
            $account->dependents->update([
                'status'=>'Used',
                'loan_account_id'=>$account->id,
                'activated_at'=>Carbon::now(),
                'expires_at'=>Carbon::now()->addDays(env('INSURANCE_MATURITY_DAYS'))
                ]);
            \DB::commit();
            return true;
        }catch(\Exeception $e){
            Log::alert($e->getMessage());
            return false;
            // return $e->getMessage();
        }

    }
    public function canBeDisbursed(){
        if($this->approved == 1 && $this->disbursed == 0){
            return true;
        }
        return false;
    }
       
    public function payFeePayments($fees,$payment_method_id,$disbursed_by,$transaction_id){
        $x = 1;
        $now  = Carbon::now();        
        foreach($fees as $fee){
            $res = $fee->update([
                'loan_account_disbursement_transaction_id'=>$transaction_id,
                'transaction_id'=>$fee->generateTransactionID($x),
                'paid_at'=>Carbon::now(),
                'paid_by'=>$disbursed_by,
                'payment_method_id'=>$payment_method_id,
                'paid'=>true,
                'created_at'=>$now
            ]);
            $x++;
        }
        return $res;
    }

    public function createInstallments($loan_acc,object $installments){
        $x=0;   //skip first installment
        $list = array();
        foreach($installments as $item){
            if ($x>0) {
                $list[] = $loan_acc->installments()->create([
                    'installment'=>$item->installment,
                    'date'=>$item->date,
                    'original_principal'=>$item->principal,
                    'original_interest'=>$item->interest,
                    'principal'=>$item->principal,
                    'interest'=>$item->interest,
                    
                    'principal_due'=>$item->principal,
                    'interest_due'=>$item->interest_due,
                    'amount_due'=>$item->amount_due,
                    'amortization'=>$item->amortization,
                    'principal_balance'=>$item->principal_balance,
                    'interest_balance'=>$item->interest_balance,
                ]);
            }
            $x++;
        }
        return $list;
    }

    public function getAmountFromDate($date){
        if($this->amountDue()->total > 0){

        }
    }
}
