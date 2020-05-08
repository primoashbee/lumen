<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PaymentMethodController extends Controller
{

    public function fetchPaymentMethods(Request $request){
        if(in_array($request->payment_type,Schema::getColumnListing('payment_methods'))){
            return PaymentMethod::where($request->payment_type, true)->orderBy('name','asc')->get(['name','id']);
        }
    }
}
