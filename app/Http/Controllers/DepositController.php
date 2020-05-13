<?php

namespace App\Http\Controllers;
use App\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index(){
      $deposit = Deposit::paginate(1);
      return view('pages.deposit-list',compact('deposit'));
    }

  	public function create(){
  		return view('pages.create-deposit');
  	}

    public function getDepositList(){
      $deposit = Deposit::paginate(10);
      return response()->json($deposit);
    }

  	public function store(Request $request){
  		$this->validator($request->all())->validate();

  		Deposit::create(
  			[
  				'product_id' => $request->product_id,
  				'name' => $request->name,
  				'description' => $request->description,
  				'minimum_deposit_per_transaction' => $request->minimum_deposit_per_transaction,
  				'deposit_portfolio' => $request->deposit_portfolio,
  				'auto_create_on_new_client' => $request->auto_create_on_new_client,
  				'deposit_interest_expense' => $request->deposit_interest_expense,
  				'auto_create_on_new_client' => $request->auto_create_on_new_client,
  				'account_per_client' => $request->account_per_client,
  				'interest_rate' => $request->interest_rate,
  				'valid_until' => Carbon::parse($request->valid_until)
  			]
  		);

  		return response()->json(['msg'=>'Deposit product succesfully created'],200);

  	}

  	public function getDepositInfo($product_id){
  		$deposit = Deposit::where('product_id',$product_id)->first();
  		return view('pages.update-deposit',compact('deposit'));
  	}

  	public function updateDeposit(Request $request){
  		$deposit = Deposit::where('product_id', $request->product_id)->first();

  		$this->validator($request->all(),true,$request->id)->validate();

  		$deposit->update(
  			[
  				'product_id' => $request->product_id,
  				'name' => $request->name,
  				'description' => $request->description,
  				'minimum_deposit_per_transaction' => $request->minimum_deposit_per_transaction,
  				'deposit_portfolio' => $request->deposit_portfolio,
  				'auto_create_on_new_client' => $request->auto_create_on_new_client,
  				'deposit_interest_expense' => $request->deposit_interest_expense,
  				'auto_create_on_new_client' => $request->auto_create_on_new_client,
  				'account_per_client' => $request->account_per_client,
  				'interest_rate' => $request->interest_rate,
  				'is_active' => $request->is_active,
  				'valid_until' => Carbon::parse($request->valid_until)
  			]
  		);
  		return response()->json(['msg'=>'Deposit product succesfully updated'],200);
  	}

  	public function validator(array $data,$for_update=false,$id=null){
    	  
    	 if ($for_update) {
            return Validator::make(
                $data,
                [
                'product_id' => 'required|unique:deposits,product_id,'.$id,
                'name' => 'required|unique:deposits,name,'.$id,
          			'valid_until' => 'required|date',
          			'account_per_client' => 'required|numeric',
          			'minimum_deposit_per_transaction' => 'required|numeric',
          			'interest_rate' => 'required|numeric',
          			'deposit_portfolio' => 'required|numeric',
          			'deposit_interest_expense' => 'required|numeric',
          			'description' => 'required|min:50|max:255',
                ]
            );
        }

        return Validator::make(
    		$data,
    		[
    			'product_id' => 'required|unique:deposits,product_id',
                'name' => 'required|unique:deposits,name',
    			'valid_until' => 'required|date',
    			'account_per_client' => 'required|numeric',
    			'minimum_deposit_per_transaction' => 'required|numeric',
    			'interest_rate'  => 'required|numeric',
    			'deposit_portfolio' => 'required|numeric',
    			'deposit_interest_expense' => 'required|numeric',
    			'description' => 'required|min:50|max:255',
    		]
    	);
    }
}
