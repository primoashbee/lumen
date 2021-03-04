<?php

namespace App\Http\Controllers;

use App\BulkDisbursement;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    public function index(){
        return view('pages.reports.index');
    }

    public function bulkDisbursementIndex(){
        $list = BulkDisbursement::distinct('bulk_disbursement_id')->select('bulk_disbursement_id')->get();
        return view('pages.reports.bulk-disbursement',compact('list'));
    }
}
