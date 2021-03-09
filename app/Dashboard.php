<?php

namespace App;

use App\Client;
use App\Office;
use App\LoanAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{

    public static function repaymentTrend($office_id){
        $now  = now()->startOfDay();
        $last = now()->startOfDay()->subDays(7);
        $office = Office::find($office_id);
        $ids = $office->getLowerOfficeIDS();
        $client_ids = Client::select('client_id')
            ->whereIn('office_id',$ids)
            ->pluck('client_id')
            ->toArray();
        return DB::table('loan_account_installments')
            ->select('date',DB::raw('ROUND(SUM(principal_due + interest),2) as total'))
            ->whereBetween('date',[$last,$now])
            ->whereExists(function($q) use ($client_ids){
                $q->select('id');
                $q->from('loan_accounts');
                $q->whereNull('closed_at');
                $q->whereRaw('loan_account_installments.loan_account_id = loan_accounts.id');
                $q->whereExists(function($q1) use ($client_ids){
                    $q1->from('clients');
                    $q1->whereIn('client_id',$client_ids);
                    $q1->whereRaw('clients.client_id = loan_accounts.client_id');
                });
            })
            ->groupBy('date')
            ->orderBy('date','asc')
            ->get();
    }

    
    public static function disbursementTrend($office_id){
        $now  = now()->startOfDay();
        $last = now()->startOfDay()->subDays(7);
        $office = Office::find($office_id);
        $ids = $office->getLowerOfficeIDS();
       
       
        $client_ids = Client::select('client_id')
            ->whereIn('office_id',$ids)
            ->pluck('client_id')
            ->toArray();
        

        $disbursements =  DB::table('loan_accounts')
            ->select(DB::raw('DATE(disbursement_date) as date'), DB::raw('SUM(disbursed_amount) as total'))
            ->whereNull('closed_by')
            ->whereBetween(DB::raw('DATE(disbursement_date)'),[$last,$now])
            ->whereExists(function($q) use ($client_ids){
                $q->from('clients');
                $q->whereIn('client_id',$client_ids);
                $q->whereColumn('clients.client_id','loan_accounts.client_id');
            })
            ->groupBy(DB::raw('DATE(disbursement_date)'))
            ->orderBy(DB::raw('DATE(disbursement_date)','asc'))
            ->get();
        
        $repayments = DB::table('loan_account_repayments')
            ->select(DB::raw('DATE(repayment_date) as date, SUM(principal_paid) as total_principal, SUM(interest_paid) as total_interest'))
            ->whereBetween('repayment_date', [$last, $now])
            ->where('reverted',false)
            ->whereExists(function($q) {
                $q->from('loan_accounts');
                $q->whereNull('closed_at');
                $q->whereColumn('loan_accounts_repayments.loan_account_id', 'loan_accounts.id');
            })
            ->whereExists(function($q) use ($client_ids){
                $q->from('clients');
                $q->whereIn('client_id',$client_ids);
                $q->whereColumn('clients.client_id','loan_accounts.client_id');
            });
    }
}
