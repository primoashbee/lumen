<?php

namespace App;

use App\Office;
use App\Events\ClientCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model
{
    protected $fillable = [
        'client_id',
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'nickname',
        'gender',
        'profile_picture_path',
        'signature_path',
        'birthday',
        'birthplace',
        'civil_status',
        'education',
        'fb_account',
        'contact_number',

        'street_address',
        'barangay_address',
        'city_address',
        'province_address',
        'zipcode',

        'business_address',
        'spouse_name',
        'spouse_contact_number',
        'spouse_birthday',

        'number_of_dependents',
        'household_size',
        'years_of_stay_on_house',
        'house_type',

        'tin',
        'umid',
        'sss',
        'mother_maiden_name',

        'notes',
        'office_id',
        'created_by',
    ];

    protected $searchables = [
        'client_id',
        'firstname',
        'middlename',
        'lastname',
        'civil_status',
        'contact_number',
        'tin',
        'umid',
        'sss'
    ];

    protected $appends = ['full_name'];



    

    public static function boot(){
        parent::boot();
        static::created(function($item) {
	         event(new ClientCreated($item));
	    });
    }

    public function deposits(){
        
        return $this->hasMany(DepositAccount::class,'client_id','client_id');
        // return $this->belongsToMany(Deposit::class, 'client_deposit', 'client_id', 'deposit_id', 'clients.client_id');
    }
    public function household_income(){
        return $this->hasOne(HouseholdIncome::class, 'client_id','client_id');
    }

    public static function clientExists($request){
            
        $client = Client::where('firstname',$request->firstname)
                ->where('lastname',$request->lastname)
                ->where('birthday',Carbon::parse($request->birthday)->toDateString());
        
        if($client->count() > 0 ){
            
            return ['msg' => 'Already exists','exists' => true, 'errors' => ['client' => ['msg'=>'Client Already Exists','client_id'=>$client->first()->client_id,'exists_at' => $client->first()->branch()->name]]];
        }

        return ['msg' => 'Does not exists','exists' => false, 'client_info'=>null];
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }
    
    public function branch(){
        return $this->office->getTopOffice('branch');
    }
    public function name(){
        return $this->firstname.' '.$this->lastname;
    }
    public function officeGet(){
        return ['id'=>$this->branch()->id,'name'=>$this->branch()->name];
    }

    public static function searchables(){
        $me = new static;
        return $me->searchables;
    }

    public static function like($office_id, $query){
        $me = new static;
        $searchables = $me->searchables;
       
        $office = Office::find($office_id);
        $office_ids = $office->getAllChildrenIDS();
        
        if(count($office_ids)>0){
            
            $office_ids = $office->getLowerOfficeIDS();
            if($query!=null){
                $clients = Client::with('office')->whereIn('office_id',$office_ids)->where(function(Builder $dbQuery) use($searchables, $query){
                    foreach($searchables as $item){  
                        $dbQuery->orWhere($item,'LIKE','%'.$query.'%');
                    }
                });
                return $clients;
            }
            $clients = Client::with('office')->whereIn('office_id',$office_ids);
            return $clients;
        }

        if($query!=null){
            $office_ids = $office->getLowerOfficeIDS();
                
            $clients = Client::with('office')->whereIn('office_id',$office_ids)->where(function(Builder $dbQuery) use($searchables,$query){
                foreach($searchables as $item){
                    $dbQuery->orWhere($item,'LIKE','%'.$query.'%');
                }
            });
            return $clients;
        }
        
        $office_ids = $office->getLowerOfficeIDS();       
        $clients = Client::with('office')->whereIn('office_id',$office_ids);
        return $clients;
    }

    public static function fcid($client_id){
        return Client::where('client_id',$client_id)->first();
    }

    public function totalDeposits(){

        $accounts = $this->deposits;

        $total = 0;

        $accounts->map(function($item) use(&$total){
            $total += $item->getRawOriginal('balance');
        });

        return env('CURRENCY_SIGN').' '.number_format($total,2,'.',',');
        
    }

    public function getBirthdayAttribute($value){
        return Carbon::parse($value)->format('F d, Y');
    }

    public function getFullNameAttribute(){
        return $this->firstname. ' '.$this->lastname;
    }
    
}
