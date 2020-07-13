<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class PostedAccruedInterest extends Model
{
    protected $fillable = ['deposit_account_id','amount','user_id'];

}
