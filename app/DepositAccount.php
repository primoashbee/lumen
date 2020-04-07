<?php

namespace App;

use App\Deposit;
use Illuminate\Database\Eloquent\Model;

class DepositAccount extends Model
{
    //

    protected $fillable = [
        'client_id',
        'deposit_id'
    ];
 
    public function deposit(){
        return $this->belongsTo(Deposit::class);
    }
}
