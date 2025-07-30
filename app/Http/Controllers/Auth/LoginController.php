<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Enums\UserType;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Onde redirecionar usuários após o login (fallback).
     *
     * @var string
     */
    protected $redirectTo = '/student/dashboard';

    /**
     * Criar uma nova instância do controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Mostrar o formulário de login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Determinar onde redirecionar usuários após login baseado no tipo.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if (!$user) {
            return '/login';
        }

        Log::info('LoginController: Redirecionando usuário baseado no tipo', [
            'user_id' => $user->id,
            'user_type' => $user->type,
            'user_email' => $user->email
        ]);

        // Usar constantes do enum para maior consistência
        switch ($user->type) {
            case UserType::ADMIN:
            case 'admin':
                return '/admin/dashboard';
            
            case UserType::ALUNO:
            case 'aluno':
                return '/student/dashboard';
            
            case UserType::INSTRUTOR:
            case 'instrutor':
                // Instrutor acessa o Painel Admin
                return '/admin/dashboard';
            
            default:
                // Fallback para usuários sem tipo definido
                Log::warning('LoginController: Tipo de usuário não reconhecido', [
                    'user_type' => $user->type,
                    'user_id' => $user->id
                ]);
                return '/student/dashboard';
        }
    }

    /**
     * O usuário foi autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Log::info('LoginController: Usuário autenticado com sucesso', [
            'user_id' => $user->id,
            'user_type' => $user->type,
            'user_email' => $user->email
        ]);

        // Verificar se o usuário está ativo
        if (!$user->isActive()) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Sua conta está inativa. Entre em contato com o administrador.'
            ]);
        }

        // Redirecionar baseado no tipo de usuário
        switch ($user->type) {
            case UserType::ADMIN:
            case 'admin':
                return redirect()->route('admin.dashboard');
            
            case UserType::ALUNO:
            case 'aluno':
                return redirect()->route('student.dashboard');
            
            case UserType::INSTRUTOR:
            case 'instrutor':
                // Instrutor acessa o Painel Admin
                return redirect()->route('admin.dashboard');
            
            default:
                Log::warning('LoginController: Redirecionamento padrão aplicado', [
                    'user_type' => $user->type,
                    'user_id' => $user->id
                ]);
                return redirect()->route('student.dashboard');
        }
    }

    /**
     * Fazer logout do usuário e redirecionar para a página inicial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('web.home')->with('success', 'Logout realizado com sucesso!');
    }
}
