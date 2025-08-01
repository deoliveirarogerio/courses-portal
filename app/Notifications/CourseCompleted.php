<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CourseCompleted extends Notification implements ShouldBroadcast
{
    public $message;
    public $url;

    public function __construct($message, $url)
    {
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database']; // necessário para realtime e salvar no banco
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => $this->url,
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message,
            'url' => $this->url,
        ]);
    }

    // Remove o broadcastAs() ou use o padrão
    public function broadcastAs()
    {
        return 'notification';
    }
}


