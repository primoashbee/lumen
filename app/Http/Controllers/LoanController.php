<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Http\Request;
use App\Rules\OnChartOfAccounts;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    //

    public function create(Request $request){
        $input = $request->all();
        $this->validator($input,'create')->validate();
        $input['created_by'] = auth()->user()->id;
        if(Loan::create($input)){
            return response()->json(['msg'=>'Loan Sucessfully Created'],200);
        }
        
    }


    public function rules($type){
        if($type=="create"){    
            $rules = [
                'account_per_client' => 'required|gt:0',
                'code' => 'required|unique:loans,code',
                'default_installment'=>'required|gt:0',
                'description'=>'required',
                'grace_period'=>'required',
                'has_tranches'=>'required',
                'installment_length'=>'required',
                'installment_method'=>'required',

                'interest_interval'=>'required',
                'interest_rate'=>'required',

                'minimum_installment'=>'required',
                'default_installment'=>'required',
                'maximum_installment'=>'required',
                
                'loan_maximum_amount'=>'required',
                'loan_minimum_amount'=>'required',

                'name'=>'required',

                'number_of_tranches'=>'sometimes',

                'valid_until'=>'sometimes|required|date',

                'loan_interest_income_active'=> [new OnChartOfAccounts, 'required','integer'],
                'loan_interest_income_in_arrears'=> [new OnChartOfAccounts, 'required','integer'],
                'loan_interest_income_matured'=> [new OnChartOfAccounts, 'required','integer'],

                'loan_portfolio_active'=> [new OnChartOfAccounts, 'required','integer'],
                'loan_portfolio_in_arrears'=> [new OnChartOfAccounts, 'required','integer'],
                'loan_portfolio_matured'=> [new OnChartOfAccounts, 'required','integer'],

                'loan_recovery'=> [new OnChartOfAccounts, 'required','integer'],
                'loan_write_off'=> [new OnChartOfAccounts, 'required','integer'],
            ];
        }
        return $rules;
    }
    public function validator(array $array,$type){

        return 
            Validator::make(
                $array,
                $this->rules($type)
            );
    }
}
