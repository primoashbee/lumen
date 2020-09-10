<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $hidden = array('pivot');
    protected $fillable = [
        'name',
        'automated',
        'calculation_type',
        'gl_account'
    ];

    public function loan(){
        return $this->belongsToMany(Loan::class,'loan_fee');
    }
}
