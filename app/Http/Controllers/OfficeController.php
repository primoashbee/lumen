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
        $request->code = $this->generateCode($request);
        if ($request->level == "cluster") {
            $request->name = $request->code;
        }
        $this->validator(
                [
                    'name' => $request->name,
                    'code' => $request->code,
                    'level' => $request->level,
                    'office_id' => $request->office_id
                ]
            )->validate();

        try{
            
            Office::create(
                [
                    'code' => $request->code,
                    'name' => $request->name,
                    'level' => $request->level,
                    'parent_id' => $request->office_id
                ]
            ); 
            return response()->json(['msg'=>'Office succesfully created'],200);
        }catch(ValidationException $e)
        {   
            return response()->json(['errors'=>$e->getErrors()],500);
        }
    }

    public function validator(array $data, $for_update=false, $id=null){
    	   
        if ($for_update) {
            return Validator::make(
                $data,
                [
                    'office_id'=>['required', new OfficeID],
                    'code' => 'required|unique:offices,code,'.$id,
                    'name' => 'required|unique:offices,name,'.$id,
                    'level' => ['required', new OfficeLevel]
                ]
            );
        }

        return Validator::make(
    		$data,
    		[
    			'office_id'=>['required', new OfficeID],
    			'code' => 'required|unique:offices,code',
                'name' => 'required|unique:offices,name',
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
	public function createLevel($level){
			$list_level = Office::getParentOfLevel($level);
			return $list_level=="" ? abort(404): view('pages.create-office',compact(['level','list_level']));
			
	}

    public function viewOffice($office){
        $officeList = Office::with('parent')->where('level', $office)->get();
        return view('pages.office-list', compact(['officeList','office']));
    }

    public function editOffice($id){
        $office = Office::find($id);
        if($office===null){
            abort(404);
        }

        $list_level = Office::getParentOfLevel($office->level);
        return view('pages.update-office',compact(['office','list_level']));
    }

    public function updateOffice(Request $request){
        
        $this->validator($request->all(),true,$request->id)->validate();
        $office = Office::find($request->id);
        try{
        $office->update(
            [
               'name' => $request->name,
                'code' => $this->generateCode($request),
                'parent_id' => $request->office_id,
                'level' => $request->level
            ]
        );
        return response()->json(['msg'=>'Office succesfully updated'],200);
        }catch(ValidationException $e)
        {   
            return response()->json(['errors'=>$e->getErrors()],500);
        }
        
    }
}
