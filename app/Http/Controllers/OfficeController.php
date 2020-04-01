<?php

namespace App\Http\Controllers;

use App\Office;
use App\Rules\OfficeId;
use App\Rules\OfficeLevel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function createOffice(Request $request){
    	$this->validator($request->all())->validate();
    	Office::create(
    		[
    			'name' => $request->name,
    			'code' => $this->generateCode($request),
    			'level' => $request->level,
    			'parent_id' => $request->office_id
    		]
    	);
    	return response()->json(['msg'=>'Office succesfully created'],200);
    }

    public function validator(array $data){
    	return Validator::make(
    		$data,
    		[
    			'office_id'=>['required', new OfficeID],
    			'name' => ['required'],
    			'code' => ['required'],
    			'level' => ['required', new OfficeLevel]
    		]
    	);
    }

    public function generateCode(Request $request)
    {
    	$levels = ['cluster','unit','account_officer'];
    	$code =  in_array($request->level, $levels) ? Office::find($request->office_id)->code."-".$request->code : $request->code;

    	if ($request->level == "account_officer") {
    		$office = Office::find($request->office_id);
    		$children = $office->getAllChildren();
    		$code = $office->code;
    		$list = collect($children)->filter(function($item){
    			return $item->level == "account_officer";
    		});
    		if ($list->count() > 0) {
    			return $code."-".$request->code. pad($list->count()+1, 2);
    		}else{
    			return $code."-".$request->code. pad(1, 2);
    		}
    	}

    	return $code;
    }
}
