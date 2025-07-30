<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Enums\UserType;

class CheckAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        // Verificar se o usuário é admin ou instrutor
        $hasAccess = $user->isAdmin() || $user->isInstrutor();

        if (!$hasAccess) {
            Log::warning('CheckAdminAccess: Acesso negado ao painel admin', [
                'user_id' => $user->id,
                'user_type' => $user->type,
                'requested_url' => $request->fullUrl()
            ]);

            // Redirecionar para o dashboard apropriado do usuário
            return $this->redirectToUserDashboard($user);
        }

        return $next($request);
    }

    /**
     * Redirecionar usuário para seu dashboard apropriado
     *
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToUserDashboard($user)
    {
        switch ($user->type) {
            case UserType::ALUNO:
            case 'aluno':
                return redirect()->route('student.dashboard')->with('error', 'Você não tem permissão para acessar o painel administrativo.');
            
            default:
                return redirect()->route('student.dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
        }
    }
}
