<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Enums\UserType;
use App\Models\User;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        // Verificar se está autenticado
        if (!Auth::check()) {
            Log::info('CheckUserType: Usuário não autenticado');
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();
        
        Log::info('CheckUserType: Verificando tipo de usuário', [
            'user_id' => $user->id,
            'user_type' => $user->type,
            'required_type' => $type,
            'route' => $request->route()->getName()
        ]);

        // Verificar se o usuário está ativo
        if (!$user->isActive()) {
            Log::warning('CheckUserType: Usuário inativo tentando acessar área restrita', [
                'user_id' => $user->id,
                'user_status' => $user->status
            ]);
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Sua conta está inativa. Entre em contato com o administrador.'
            ]);
        }

        // Verificar o tipo de usuário
        $hasAccess = false;
        
        switch ($type) {
            case 'admin':
                $hasAccess = $user->isAdmin();
                break;
            
            case 'aluno':
            case 'student':
                $hasAccess = $user->isAluno();
                break;
            
            case 'instrutor':
            case 'instructor':
                $hasAccess = $user->isInstrutor();
                break;
            
            default:
                Log::error('CheckUserType: Tipo de usuário não reconhecido no middleware', [
                    'required_type' => $type
                ]);
                $hasAccess = false;
        }

        if (!$hasAccess) {
            Log::warning('CheckUserType: Acesso negado', [
                'user_id' => $user->id,
                'user_type' => $user->type,
                'required_type' => $type,
                'route' => $request->route()->getName()
            ]);

            // Redirecionar para o dashboard apropriado do usuário
            return $this->redirectToUserDashboard($user);
        }

        Log::info('CheckUserType: Acesso permitido', [
            'user_id' => $user->id,
            'user_type' => $user->type,
            'required_type' => $type
        ]);

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
            case UserType::ADMIN:
            case 'admin':
                return redirect()->route('admin.dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
            
            case UserType::ALUNO:
            case 'aluno':
                return redirect()->route('student.dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
            
            case UserType::INSTRUTOR:
            case 'instrutor':
                return redirect('/instructor/dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
            
            default:
                return redirect()->route('student.dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
        }
    }
}
