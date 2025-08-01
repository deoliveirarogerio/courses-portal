<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se está autenticado
        if (!auth()->check()) {
            Log::info('AdminMiddleware: Usuário não autenticado');
            abort(403, 'Acesso negado. Faça login para continuar.');
        }

        $user = auth()->user();
        Log::info('AdminMiddleware: Usuário autenticado', [
            'user_id' => $user->id,
            'user_type' => $user->type,
            'user_email' => $user->email
        ]);

        // Verificar se é admin usando o método do model
        if (!$user->isAdmin()) {
            Log::info('AdminMiddleware: Usuário não é admin', [
                'user_type' => $user->type,
                'expected_type' => [
                    'admin',
                    'instrutor'
                ]
            ]);
            abort(403, 'Acesso negado. Apenas administradores podem acessar esta área.');
        }

        Log::info('AdminMiddleware: Acesso permitido para admin');
        return $next($request);
    }
}
