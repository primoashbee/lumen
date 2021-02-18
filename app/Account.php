<?php

namespace App;

use App\Loan;
use App\Deposit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable = ['client_id','accountable_id','accountable_id_type'];

    public function accountable(){
        return $this->morphTo();
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id','client_id');
    }

    public static function repaymentsFromDate(array $array, $create_ccr = false){
        $office_id = $array['office_id'];
        $date = Carbon::parse($array['date']);
        $loan_product_id = $array['loan_account_id'];

        $office = Office::find($office_id);
        $ids = $office->getLowerOfficeIDS();

        $client_ids = Client::select('client_id')
            ->whereIn('office_id',$ids)
            ->pluck('client_id');

        $deposit_ids = $array['deposit_product_ids'];
        $accounts = LoanAccount::with([
            'client'=>function($q) use($client_ids){
                $q->select('client_id','firstname','lastname');
                $q->whereIn('client_id',$client_ids);
                
            },
            'product:id,code',
            'client.deposits'=>function($q) use ($deposit_ids){
                $q->select('id','client_id','deposit_id','balance');
                $q->whereIn('deposit_id',$deposit_ids);
                $q->orderBy('deposit_id','ASC');
            },
            'client.deposits.type' => function($q) {
                $q->select('id','product_id');
            }
        ])->select('id','client_id','loan_id')->where('loan_id',$loan_product_id)->whereNull('closed_by')->whereIn('client_id',$client_ids)->get();
        // ])->selectRaw('select id, client_id, loan_id')->where('loan_id',$loan_product_id)->whereNull('closed_by')->whereIn('client_id',$client_ids)->get();
        


        $deposit_types = Deposit::select('product_id')->whereIn('id',$deposit_ids)->orderBy('id','ASC')->pluck('product_id');
        $deposit_summary = [];
        $deposit_types->map(function($x) use(&$deposit_summary){
            
            $deposit_summary[] = ['type'=>$x,'total_balance'=>0];
        });
        
        $list = collect();
        $total_interest = 0;
        $total_principal = 0;
        $total_amount_due = 0;
        $total = ['loan'=>[
                    'total_interest'=>0,
                    'total_principal'=>0,
                    'total_amount_due'=>0,
                ],'deposits'=>$deposit_summary ];
        
        if ($accounts->count() > 0) {
            $accounts->map(function ($account) use ($date, &$list, &$total) {
                $repayment_info =$account->getDuesFromDate($date);
                
                $account->repayment_info = $repayment_info;

                $total['loan']['total_interest']+=$repayment_info->interest;
                $total['loan']['total_principal']+=$repayment_info->principal;
                $total['loan']['total_amount_due']+=$repayment_info->amount_due;

                $total['loan']['_total_interest']=money($total['loan']['total_interest'],2);
                $total['loan']['_total_principal']=money($total['loan']['total_principal'],2);
                $total['loan']['_total_amount_due']=money($total['loan']['total_amount_due'],2);
                
                $account->client->deposits->map(function($dep) use (&$total){
                    collect($total['deposits'])->each(function($item, $key) use ($dep, &$total){
                        if($dep->type->product_id==$item['type']){
                            $total['deposits'][$key]['total_balance'] += $dep->balance;
                            $total['deposits'][$key]['_total_balance'] = money($total['deposits'][$key]['total_balance'],2);
                        }
                    });
                });
                $list->push($account);
            });
        }

        
        $summary = new \stdClass;
        $summary->loan_accounts = $list;
        $summary->interest_total = $total_interest;
        $summary->total_principal = $total_principal;
        $summary->total_amount = $total_amount_due;
        $summary->has_loan = count($list) > 0;
        $summary->has_deposit = count($deposit_ids) > 0;
        $summary->loan_type = Loan::select('code')->find(1)->code;
        $summary->deposit_types = $deposit_types;
        $summary->total = $total;
        $summary->repayment_date = $date->format('F d, Y');
        $summary->office = $office->name;

        $file = public_path('temp/').$summary->office.' - '.$summary->repayment_date.'.pdf';            
        $name = $summary->office.' - '.$summary->repayment_date.'.pdf';
        $summary->name = $name;
        
        return $summary;
    }
}
