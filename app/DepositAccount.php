<?php

namespace App;

use App\User;
use App\Deposit;
use Carbon\Carbon;
use App\Rules\OfficeID;
use App\DepositTransaction;
use App\PostedAccruedInterest;
use App\Rules\TransactionType;
use App\Rules\PaymentMethodList;
use App\Rules\PreventFutureDate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use App\Rules\WithdrawAmountLessThanBalance;
use App\Rules\PreventLaterThanLastTransactionDate;

class DepositAccount extends Model
{
    protected $appends = [
        'balance_formatted',
        'new_balance',
        'new_balance_formatted',
        'accrued_interest_formatted'
    ];
    protected $fillable = [
        'client_id',
        'deposit_id',
        'balance',
        'accrued_interest',
        'status',
        'repayment_date',
        'user_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:F d, Y',
    ];
    protected $dates = [
        'created_at',
        'updated_at',

    ];
    public function type(){
        return $this->belongsTo(Deposit::class,'deposit_id');
    }

    public function getBalanceFormattedAttribute(){
        // return env('CURRENCY_SIGN').' '.number_format($value,2,'.',',');
        return env('CURRENCY_SIGN').' '.numberFormat($this->getRawOriginal('balance'));
        // }
    }
    

    public function deposit(array $data){
        // $rules = [
        //     'office_id' =>['required', new OfficeID()],
        //     'amount'=>['required','numeric'],
        //     'payment_method'=>['required',new PaymentMethodList()],
        //     'deposit_account_id'=>['required','exists:deposit_accounts,id'],
        //     'repayment_date'=>['required','date', new PreventFutureDate(), new PreventLaterThanLastTransactionDate($data['deposit_account_id'])],
        //     'type'=>['required', new TransactionType()],
        //     'receipt_number'=>['required','unique:receipts,receipt_number']
        // ];
        // \Validator::make($data,$rules)->validate();
        \DB::beginTransaction();
        try{
            $new_balance = $this->getRawOriginal('balance') + $data['amount'];
            $transaction = $this->transactions()->create([
                'transaction_id' => uniqid(),
                'transaction_type'=>'Deposit',
                'amount'=>$data['amount'],
                'payment_method'=>$data['payment_method'],
                'repayment_date'=>$data['repayment_date'],
                'user_id'=> $data['user_id'],
                'balance' => $new_balance,
                'receipt_number'=>$data['receipt_number']
            ]);
            $transaction->receipt()->create(['receipt_number'=>$data['receipt_number']]);
            $this->balance = $new_balance;
            $payload = ['date'=>$data['repayment_date'],'amount'=>$data['amount']];
            event(new \App\Events\DepositTransaction($payload,$data['office_id'],$data['user_id'],$data['payment_method'],'deposit'));
            $this->save();
            \DB::commit();
        }catch(Exception $e){

        }
        

    }

    public function withdraw(array $data){
        if($this->getRawOriginal('balance') < $data['amount']){
            return false;
        }
        $new_balance = $this->getRawOriginal('balance') - $data['amount'];

        \DB::beginTransaction();
        try {
            $transaction = DepositTransaction::create([
            'transaction_id' => uniqid(),
            'deposit_account_id' => $this->id,
            'transaction_type'=>'Withdraw',
            'amount'=>$data['amount'],
            'payment_method'=>$data['payment_method'],
            'repayment_date'=>$data['repayment_date'],
            'user_id'=> $data['user_id'],
            'balance' => $new_balance,
            'receipt_number'=>$data['receipt_number']
        ]);

            $transaction->receipt()->create(['receipt_number'=>$data['receipt_number']]);
            $payload = ['date'=>$data['repayment_date'],'amount'=>$data['amount']];
            event(new \App\Events\DepositTransaction($payload,$data['office_id'],$data['user_id'],$data['payment_method'],'withdraw'));
            $this->balance = $new_balance;
            $this->save();
            \DB::commit();

        }catch(Exception $e){

        }
    }

    public function payCTLP(array $data){
        try {
            if ($this->getRawOriginal('balance') < $data['amount']) {
                return false;
            }
            $new_balance = $this->getRawOriginal('balance') - $data['amount'];

            DepositTransaction::create([
                'transaction_id' => uniqid(),
                'deposit_account_id' => $this->id,
                'transaction_type'=>'CTLP',
                'amount'=>$data['amount'],
                'payment_method'=>$data['payment_method'],
                'repayment_date'=>$data['repayment_date'],
                'user_id'=> $data['user_id'],
                'balance' => $new_balance
            ]);
        
        
            $this->balance = $new_balance;
            $this->save();
            $payload = ['date'=>$data['repayment_date'],'amount'=>$data['amount']];
            event(new \App\Events\DepositTransaction($payload,$data['office_id'],$data['user_id'],$data['payment_method'],'CTLP'));
            \DB::commit();
        } catch (Exeception $e){

        }
    }
    public function revertPayCTLP(array $data){
        
        $new_balance = $this->getRawOriginal('balance') + $data['amount'];
        DepositTransaction::create([
            'transaction_id' => uniqid(),
            'deposit_account_id' => $this->id,
            'transaction_type'=>'Deposit',
            'amount'=>$data['amount'],
            'payment_method'=>$data['payment_method'],
            'repayment_date'=>$data['repayment_date'],
            'user_id'=> $data['user_id'],
            'balance' => $new_balance
        ]);
            
        
        $this->balance = $new_balance;
        return $this->save();
    }
    public function transactions(){
        return $this->hasMany(DepositTransaction::class)->orderBy('created_at','desc');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id','client_id');
    }

    public function hasAccruedInterestForToday(){
       $post = DailyAccruedInterest::where('deposit_account_id',$this->id)->orderBy('created_at')->first();
       if($post !== null){           
            $days = $post->created_at->diffInDays(Carbon::now());
            return $days == 0 ? false : true;
       }
       return false;
    }

    public static function listForAccruingInterestToday(){
        $latestPostings = DB::table('daily_accrued_interests')
                                ->select('id', 'deposit_account_id', 'amount')
                                ->where(DB::raw('date(created_at)'),'=',DB::raw('CURDATE()'));
                                
        $depositAccounts = DB::table('deposit_accounts as da')
                                ->select('da.id as da_id', 'da.client_id', 'pai.amount')
                                ->leftJoinSub($latestPostings,'pai', function($join){
                                    $join->on('da.id','=','pai.deposit_account_id');
                                })->whereNull('pai.id');
        return DepositAccount::find($depositAccounts->get()->pluck('da_id'));

    }

    public static function accrueInterestAll(){
        $list = DepositAccount::listForAccruingInterestToday();

        $posting_records = array();
        $ctr=0;
        if($list->count() > 0){
            $list->map(function($item) use (&$posting_records, &$ctr){
                $posting_records[] = $item->accrueInterest();
                $ctr++;
            });
        }
        
        return DailyAccruedInterest::insert($posting_records);
        
        
    }

    public function accrueInterest($by_scheduler=true){
                $info = array();
                $info['user_id'] = 1;
                if(!$by_scheduler){
                    $info['user_id'] = auth()->user()->id;
                }
                $interest_rate = $this->type->getRawOriginal('interest_rate') / 100;
                $daily_interest_rate = $interest_rate / 365;
                $accrued_interest_today = round($daily_interest_rate * $this->getRawOriginal('balance'),2);
                $accrued_interest = $this->getRawOriginal('accrued_interest');
                $accumulated_accrued_interest =  $accrued_interest + $accrued_interest_today;
                $this->accrued_interest = $accumulated_accrued_interest;

                $info['deposit_account_id'] = $this->id;
                $info['amount'] = $accrued_interest_today; 
                $info['created_at'] = Carbon::now(); 
                $info['updated_at'] = Carbon::now(); 
                
                $this->save();
                return $info;
   
    }


    public static function listForInterestPosting($office_id=null){
        if($office_id==null){
            return DepositAccount::where('accrued_interest','>',0)->get();
        }
        $ids =  Client::where('office_id',$office_id)->get();

        return DepositAccount::whereIn('client_id',$ids)->where(function($query){
            $query->where('accrued_interest','>',0);
        })->get();


    }

    public function postInterest(){
        
       
        $current_balance = $this->getRawOriginal('balance');
        $accrued_interest = $this->getRawOriginal('accrued_interest');
        $new_balance = $current_balance + $accrued_interest;
        $this->accrued_interest = 0;
        $this->balance = $new_balance;
        if ($accrued_interest > 0) {

            $this->transactions()->create([
                'transaction_id' => uniqid(),
                'transaction_type'=>'Interest Posting',
                'amount'=>$accrued_interest,
                'payment_method'=>$this->branch()->defaultPaymentMethods()['for_deposit'],
                'repayment_date'=>Carbon::now(),
                'user_id'=> 1,
                'balance' => $new_balance
            ]);
            
        }else{
            return false;
        }
        return $this->save();
    }
    public function postInterestByUser(array $data, $info=false){   
        $current_balance = $this->getRawOriginal('balance');
        $accrued_interest = $this->getRawOriginal('accrued_interest');
        $new_balance = $current_balance + $accrued_interest;
        $this->accrued_interest = 0;
        $this->balance = $new_balance;

        if ($accrued_interest > 0) {
            if ($info==false) {
                $transaction = $this->transactions()->create([
                    'transaction_id' => uniqid(),
                    'transaction_type'=>'Interest Posting',
                    'amount'=>$accrued_interest,
                    'payment_method'=>PaymentMethod::interestPosting()->id,
                    'repayment_date'=>Carbon::now(),
                    'user_id'=> $data['user_id'],
                    'balance' => $new_balance
                ]);
                $transaction->journal()->create([
                    'journal_voucher_number'=>$data['journal_voucher_number'],
                    'amount'=>$accrued_interest,
                    'transaction_date'=>now(),
                  
                    'notes'=>'Interest Posting for Deposit Account'
                ]);
            }else{
                $transaction = $this->transactions()->create([
                    'transaction_id' => uniqid(),
                    'transaction_type'=>'Interest Posting',
                    'amount'=>$accrued_interest,
                    'payment_method'=>$info['payment_method'],
                    'repayment_date'=>Carbon::now(),
                    'user_id'=> auth()->user()->id,
                    'balance' => $new_balance
                ]);

                
            }
        }else{
            return false;
        }
        return $this->save();
    }
    public function postInterestAll(){
        $list = DepositAccount::listForInterestPosting();
    }
    
    public function getStatusAttribute($value){
        return ucwords($value);
    }
    public function getAmountAttribute(){
        return 0;
    }

    

    public function getAccruedInterestAttribute($value){
        return round($value,4); 
    }

    public function getNewBalanceAttribute(){
        return round($this->getRawOriginal('balance') + $this->getRawOriginal('accrued_interest'),4);
    }
    public function getNewBalanceFormattedAttribute(){
        return env('CURRENCY_SIGN')." ".number_format(round($this->getRawOriginal('balance') + $this->getRawOriginal('accrued_interest'),4),2);
    }
    public function getRawBalanceAttribute(){
        return round($this->getRawOriginal('balance'),2);   
    }
    public function getAccruedInterestFormattedAttribute(){
        return  env('CURRENCY_SIGN')." ".round($this->getRawOriginal('accrued_interest'),4);   
    }

    public function lastTransaction(){
        return $this->transactions->first();
    }


    public function branch(){
        return $this->client->office;
    }

    public function account(){
        return $this->morphOne(Account::class, 'accountable');
    }

    
}
