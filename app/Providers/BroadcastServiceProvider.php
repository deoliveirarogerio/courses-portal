<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Middleware personalizado para debug
        Broadcast::routes(['middleware' => ['web', 'auth', function ($request, $next) {
            Log::info('Broadcasting auth middleware', [
                'user' => Auth::user()->id,
                'request_data' => $request->all(),
                'headers' => $request->headers->all(),
                'url' => $request->url(),
                'method' => $request->method()
            ]);
            
            $response = $next($request);
            
            Log::info('Broadcasting auth response', [
                'status' => $response->getStatusCode(),
                'content' => $response->getContent(),
                'headers' => $response->headers->all()
            ]);
            
            return $response;
        }]]);

        require base_path('routes/channels.php');
    }
}


