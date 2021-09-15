<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;

    public $message;

    public $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $username, $task )
    {
        $this -> task = $task;
        $this->username = $username;
        $this->message  = "{$username} Добавил задачу: {$task -> task}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('channel-name');
        return new Channel('task-added');
    }
}
