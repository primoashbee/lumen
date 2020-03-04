<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','middlename','gender','birthday','notes','email', 'password','created_by',
   ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function name(){
        return $this->firstname.' '.$this->lastname;
    }
    
    public function office(){
        return $this->belongsToMany(Office::class)->orderBy('office_id');
    }

    public function scopes(){
       
        $offices = $this->office;

        $scopes = [];
        foreach($offices as $office){
            array_push($scopes,$office);
            $scopes = array_merge($scopes, $office->getChild());
        }

        return $scopes;
    }
    public function scopesID(){
       
        $offices = $this->office;

        $scopes = [];
        foreach($offices as $office){
            array_push($scopes,$office->id);
            $scopes = array_merge($scopes, $office->getChildIDS());
        }

        return $scopes;
    }


}
