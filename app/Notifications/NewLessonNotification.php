<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewLessonNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $message;
    public $url;
    private $userId;

    public function __construct($message, $url)
    {
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        $this->userId = $notifiable->id; // Armazenar aqui
        Log::info("📋 Enviando notificação de lição via database e broadcast para usuário: " . $notifiable->id);
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        Log::info("💾 Salvando lição no banco para usuário: " . $notifiable->id);
        return [
            'message' => $this->message,
            'url' => $this->url,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->userId = $notifiable->id; // Garantir que está definido
        Log::info("📡 Broadcasting lição para usuário: " . $notifiable->id);
        return new BroadcastMessage([
            'message' => $this->message,
            'url' => $this->url,
        ]);
    }

    public function broadcastAs()
    {
        return 'notification';
    }

    public function broadcastOn()
    {
        Log::info("📡 Canal da lição: App.Models.User." . $this->userId);
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }
}

