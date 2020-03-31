<?php

namespace App\Http\Controllers;

use App\Office;
use Illuminate\Support\Facades\Validator;
use App\Rules\OfficeID;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function createOffice(Request $request){
    	$office = $this->validator($request->all())->validate();
    	Office::create(
    		[
    			'name' => $request->name,
    			'code' => $request->code,
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
    			'code' => ['required']
    		]
    	);
    }
}
