<?php

namespace App\Listeners;

use App\Deposit;
use Carbon\Carbon;
use App\DepositAccount;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $deposit_ids = Deposit::autoCreate()->pluck('id');
        if(count($deposit_ids)>0){
            $accs = array();
            foreach($deposit_ids as $key => $value){
                $accs[] = array(
                    'client_id'=>$event->client->client_id,
                    'deposit_id'=>$value,
                    'balance' => rand(500,10000)/10,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                );
            }
           
            DepositAccount::insert($accs);
        }
        Log::info('Client created : '.$event->client->client_id);
    }
}
