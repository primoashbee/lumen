<?php

namespace App\Http\Controllers;

use App\Client;
use App\Dependent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DependentCreateRequest;
use App\Rules\DependentStatus;

class DependentController extends Controller
{
    public function createDependents(DependentCreateRequest $request){
        $data=  $this->formatRequest($request->all());
        if(Client::find($request->client_id)->dependents()->create($data)){
            return response()->json(['msg'=>'Dependent Created'], 200);
        }
            return response()->json(['msg'=>'Something Went Wrong'], 404);
    }

    public function formatRequest(array $data){
        $values = [];
        foreach($data as $key=>$value){
            
             if(is_array($value)){
                 foreach($value as $sub_key=>$sub_value){
                    $values[$key.'_'.$sub_key]=$sub_value;
                 }
             }else{
                $values[$key]=$value;
             }
        }
        $values['created_by']=auth()->user()->id;
        return $values;
        
    }

    public function updateDependentStatus(Request $request){
    
        $types = ['activate','deactivate'];
        
        Validator::make($request->all(),[
            'application_number'=>'required|exists:dependents,application_number',
            'type'=> [new DependentStatus]
        ])->validate();
        Dependent::where('application_number',$request->application_number)->first()->client_id;
        if($request->type=="activate"){
            return Dependent::where('application_number',$request->application_number)->update(['active'=>true]);    
        }
        return Dependent::where('application_number',$request->application_number)->update(['active'=>false]);
    }
}
