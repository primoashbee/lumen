<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use App\Rules\Gender;
use App\Rules\OfficeID;
use App\HouseholdIncome;
use App\Rules\HouseType;
use App\Rules\CivilStatus;
use Illuminate\Http\Request;
use App\Rules\EducationalAttainment;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    
    public function index(){
        $branches = auth()->user()->scopesBranch();
        return view('pages.create-client',compact('branches'));
    }
    
    public function create(Request $request){

        return response()->json(['success' => 'success','msg'=>'Client Succesfully Created'], 200);
        $this->validator($request->all())->validate();
        $client_id = makeClientID($request->office_id);

        Client::create([
            'client_id' => $client_id,
            'firstname' => $request->firstname,
            'middlename'=>$request->middlename,
            'lastname'  =>$request->lastname,
            'suffix'=>$request->suffix,
            'nickname'=>$request->firstname,
            'gender'=> $request->gender,
            'profile_picture_path' => 'https://via.placeholder.com/150',
            'signature_path' => 'https://via.placeholder.com/150',
            'birthday' => Carbon::parse($request->birthday),
            'birthplace' => $request->birthplace,
            'civil_status' => $request->civil_status,
            'education' => $request->education,
            'fb_account' => $request->fb_account,
            'contact_number'=>$request->contact_number,
            'street_address'=> $request->street_address,
            'barangay_address' => $request->barangay_address,
            'city_address' => $request->city_address,
            'province_address' => $request->province_address,
            'zipcode' => $request->zipcode,
            'business_address' =>$request->business_address,
            'spouse_name' => $request->spouse_name,
            'spouse_contact_number' => $request->spouse_contact_number,
            'spouse_birthday' =>  Carbon::parse($request->spouse_birthday),
            'number_of_dependents' => $request->number_of_dependents,
            'household_size' =>$request->household_size,
            'years_of_stay_on_house' => $request->years_of_stay_on_house,
            'house_type' => $request->house_type,
            'tin' => $request->tin,
            'umid' => $request->umid,
            'sss' => $request->sss,
            'mother_maiden_name' => $request->mother_maiden_name,
            'notes' => $request->notes,
            'office_id' => $request->office_id,
            'created_by' => auth()->user()->id
        ]);
        
        $service_type_monthly_gross_income = intval($request->service_type_monthly_gross_income);
        $employed_monthly_gross_income = intval($request->employed_monthly_gross_income);
        $spouse_service_type_monthly_gross_income = intval($request->spouse_service_type_monthly_gross_income);
        $spouse_employed_monthly_gross_income = intval($request->spouse_employed_monthly_gross_income);

        $total_household_income = $service_type_monthly_gross_income + $employed_monthly_gross_income + $spouse_service_type_monthly_gross_income + $spouse_employed_monthly_gross_income;
        
        HouseholdIncome::create([
            'client_id'=>$client_id,

            'is_self_employed'=>$request->is_self_employed,
            'service_type'=>$request->service_type,
            'service_type_monthly_gross_income'=>$service_type_monthly_gross_income,
            'is_employed'=>$request->is_employed,
            'employed_position'=>$request->employed_company_name,
            'employed_monthly_gross_income'=>$employed_monthly_gross_income,

            'spouse_is_self_employed'=>$request->spouse_is_self_employed,
            'spouse_service_type'=>$request->spouse_service_type,
            'spouse_service_type_monthly_gross_income'=>$spouse_service_type_monthly_gross_income,
            'spouse_is_employed'=>$request->spouse_is_employed,
            'spouse_employed_position'=>$request->spouse_employed_position,
            'spouse_employed_company_name'=>$request->spouse_employed_company_name,
            'spouse_employed_monthly_gross_income'=>$spouse_employed_monthly_gross_income,

            'has_remittance'=>$request->has_remittance,
            'has_pension'=>$request->pension_amount,
            'total_household_income'=>$total_household_income
        ]);


       
    }

    public function validator(array $data){

            return Validator::make($data, [
                'office_id'=>['required', new OfficeID],
                'firstname'=>'required',
                'lastname'=>'required',
                'gender'=>['required', new Gender],
                'contact_number'=>'required',
                'birthday'=>'required|date',
                'birthplace'=>'required',
                'education'=>['required', new EducationalAttainment],
                'civil_status'=>['required', new CivilStatus],
                'street_address'=>'required',
                'barangay_address'=>'required',
                'city_address'=>'required',
                'province_address'=>'required',
                'zipcode'=>'required',
                'business_address'=>'required',
                'number_of_dependents'=>'required|integer|gt:0',
                'household_size'=>'required|integer|gt:0',
                'years_of_stay_on_house'=>'required|integer|gt:0',
                'house_type'=>['required', new HouseType],
                'spouse_name' => 'required',
                'spouse_contact_number' => 'required',
                'spouse_birthday' => 'required|date',
                'tin'=>'required',
                'sss'=>'required',
                'umid'=>'required',
                'mother_maiden_name'=>'required',
                'mother_maiden_name'=>'required',
                'total_household_income'=>'required|integer|gt:0'
            ]);
    }
}
