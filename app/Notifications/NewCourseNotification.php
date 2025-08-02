<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class NewCourseNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $message;
    public $url;
    private $userId;

    public function __construct($message, $courseId = null)
    {
        $this->message = $message;
        
        // Gerar URL correta usando route helper
        if ($courseId) {
            $this->url = route('student.course.detail', $courseId);
        } else {
            $this->url = route('student.courses');
        }
    }

    public function via($notifiable)
    {
        $this->userId = $notifiable->id; // Armazenar aqui
        //\Log::info("📋 Enviando notificação via database e broadcast para usuário: " . $notifiable->id);
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
       // \Log::info("💾 Salvando no banco para usuário: " . $notifiable->id);
        return [
            'message' => $this->message,
            'url' => $this->url,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->userId = $notifiable->id; // Garantir que está definido
        //\Log::info("📡 Broadcasting para usuário: " . $notifiable->id);
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
        //\Log::info("📡 Canal: App.Models.User." . $this->userId);
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }
}





