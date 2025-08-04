<?php

namespace App\Events;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLeftRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $room;

    public function __construct(User $user, ChatRoom $room)
    {
        $this->user = $user;
        $this->room = $room;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat-room.' . $this->room->id);
    }

    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'type' => $this->user->type,
            ],
            'message' => $this->user->name . ' saiu da sala'
        ];
    }
}