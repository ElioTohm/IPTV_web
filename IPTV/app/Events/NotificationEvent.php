<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $CLIENT_ID;

    private $MESSAGE;

    private $TYPE;

    private $IMAGE;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($clientid, $type, $message, $image)
    {
        $this->CLIENT_ID = $clientid;
        $this->MESSAGE = $message;
        $this->TYPE = $type;
        $this->IMAGE = $image;
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
        return ['type' => $this->TYPE,
                    'message' => $this->MESSAGE,        
                    'image' => $this->IMAGE,
                ];
    }
}
