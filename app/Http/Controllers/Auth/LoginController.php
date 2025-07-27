<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Onde redirecionar usuários após o login.
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
        $user = auth()->user();

        if ($user && $user->type === 'aluno') { // Corrigido: 'type' ao invés de 'tipo_usuario'
            return '/student/dashboard';
        } elseif ($user && $user->type === 'instrutor') {
            return '/instructor/dashboard';
        } elseif ($user && $user->type === 'admin') {
            return '/admin/dashboard';
        }

        return '/home';
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
        if ($user->type === 'aluno') { // Corrigido: 'type' ao invés de 'tipo_usuario'
            return redirect()->route('student.dashboard');
        } elseif ($user->type === 'instrutor') {
            return redirect()->route('instructor.dashboard');
        } elseif ($user->type === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended($this->redirectPath());
    }
}
