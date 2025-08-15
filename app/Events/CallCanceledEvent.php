<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallAcceptedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointmentId;
    public $roomUrl;
    public $doctorId;

    public function __construct($appointmentId, $roomUrl, $doctorId)
    {
        $this->appointmentId = $appointmentId;
        $this->roomUrl = $roomUrl;
        $this->doctorId = $doctorId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->appointmentId);
    }
}