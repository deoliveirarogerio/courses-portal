<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Log;

class NewModuleNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $message;
    public $url;
    private $userId;

    public function __construct($message, $moduleId = null, $courseId = null)
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
        $this->userId = $notifiable->id;
        Log::info("📋 Enviando notificação de módulo via database e broadcast para usuário: " . $notifiable->id);
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        Log::info("💾 Salvando módulo no banco para usuário: " . $notifiable->id);
        return [
            'message' => $this->message,
            'url' => $this->url,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $this->userId = $notifiable->id;
        Log::info("📡 Broadcasting módulo para usuário: " . $notifiable->id);
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
        Log::info("📡 Canal do módulo: App.Models.User." . $this->userId);
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }
}
