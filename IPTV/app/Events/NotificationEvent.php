<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $CLIENT_ID;

    private $MESSAGE;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($clientid, $message)
    {
        $this->CLIENT_ID = $clientid;
        $this->MESSAGE = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new channel('Notification_To_' . $this->CLIENT_ID);
    }
    
    public function broadcastWith()
    {
        return ['Message' => $this->MESSAGE];
    }
}
