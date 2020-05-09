<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyAccruedInterest extends Model
{
    protected $fillable = ['deposit_account_id','amount','user_id'];
}
