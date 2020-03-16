<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function household_income(){
        return $this->hasOne(HouseholdIncome::class, 'client_id','client_id');
    }
}
