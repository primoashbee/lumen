<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    protected $fillable = ['client_id','package_id','application_number','firstname','middlename','lastname','birthday','relation'];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
