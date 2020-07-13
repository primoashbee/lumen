<?php

namespace App\Http\Controllers;

use App\Deposit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getItems(Request $request){
        if($request->product_type=="deposit"){
            if(!$request->has('product_code')){

                $accs = Deposit::all()->toArray();
                $all = array("id"=>"ALL","name"=>"ALL");
                array_unshift($accs, $all);

                return $accs;
            }
            return Deposit::where('product_id',$request->product_code)->first();
        }
    }
}
