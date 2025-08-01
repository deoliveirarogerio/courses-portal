<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    Log::info('Channel authorization attempt', [
        'user_id' => $user ? $user->id : 'null',
        'channel_id' => $id,
        'request_data' => request()->all(),
        'headers' => request()->headers->all()
    ]);
    
    if (!$user) {
        Log::error('No user found in channel authorization');
        return false;
    }
    
    $authorized = (int) $user->id === (int) $id;
    
    Log::info('Channel authorization result', [
        'authorized' => $authorized,
        'user_id' => $user->id,
        'channel_id' => $id
    ]);
    
    return $authorized;
});
