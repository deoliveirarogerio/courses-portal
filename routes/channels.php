<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatRoom;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to control if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal para salas de chat
Broadcast::channel('chat-room.{roomId}', function ($user, $roomId) {
    $room = ChatRoom::find($roomId);
    
    if (!$room) {
        return false;
    }
    
    // Verificar se o usuário pode acessar a sala
    return $room->canJoin($user->id) || $room->isParticipant($user->id);
});

// Canal para notificações do fórum
Broadcast::channel('forum-notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

