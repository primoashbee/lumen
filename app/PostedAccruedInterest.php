<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class PostedAccruedInterest extends Model
{
    protected $fillable = ['deposit_account_id','amount','user_id'];

    public static function boot(){

        parent::boot();

        // static::created(function($item){
        //     $row = PostedAccruedInterest::where('deposit_id',$item->deposit_id)->orderBy('created_at','desc')->first();
        //     var_dump($row);
        //     if($row->created_at->diffInDays(Carbon::now()) >= 0){
        //         Log::alert('Already posted interest for today');
        //     }
            
        // });
        
    }
}
