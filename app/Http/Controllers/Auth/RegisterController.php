<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use App\OfficeUser;
use App\Rules\OfficeID;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['string', 'max:255'],
            'gender' => ['required','string', 'max:255'],
            'birthday' => ['required','date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_to_office_id'=> ['required', new OfficeID]
        ],[
            'user_to_office_id.required'=>'You should select atleast 1 office'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'middlename' => $data['middlename'],
            'gender' => $data['gender'],
            'birthday' => Carbon::parse($data['birthday']),
            'email' => $data['email'],
            'notes'=>$data['notes'],
            'password' => Hash::make($data['password'])
        ]);
        
        $office_ids_raw = json_decode($data['user_to_office_id']);
        $office_ids = [];
        
        foreach($office_ids_raw as $key => $value){
            OfficeUser::create([
                'user_id'=>$user->id,
                'office_id'=>$value->key
            ]);
        }
    
        return $user;
    }
}
