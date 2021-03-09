<?php

namespace App\Events;

use App\Office;
use App\PaymentMethod;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class DepositTransaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $type;
    public $data;
    private $office_id;
    public function __construct($payload, $office_id, $user_id, $payment_method_id, $type)
    {
        $office = Office::find($office_id)->name;
        $by = User::find($user_id)->full_name;
        $payment = PaymentMethod::find($payment_method_id)->name;
        if ($type=="deposit") {
            $payload['msg'] = 'CBU Deposit ' . money($payload['amount'], 2) . ' at '. $office  . ' by ' . $by . ' [' . $payment . ']';
        }
        if ($type=="withdraw") {
            $payload['msg'] = 'CBU Withdrawal ' . money($payload['amount'], 2) . ' at '. $office  . ' by ' . $by . ' [' . $payment . ']';
        }
        $this->office_id = $office_id;
        $this->data = $payload;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('dashboard.notifications.'.$this->office_id);
    }

    public function broadcastAs(){
        if($this->type=="deposit"){
           return 'cbu-deposit';
        }
        if($this->type=="withdraw"){
           return 'cbu-withdraw';
        }
    }
}
