<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BulkLoanDisbursed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $office_id;

    public function __construct($msg,$office_id)
    {
        $this->data['msg'] = $msg;
        $this->office_id = $office_id;
    }
  
    public function broadcastOn()
    {
        return new PrivateChannel('dashboard.notifications.' .$this->office_id);
    }
  
    public function broadcastAs()
    {
        return 'bulk-loan-disbursed';
    }
}

