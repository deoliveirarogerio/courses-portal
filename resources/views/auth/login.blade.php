@extends('web._theme')

@section('title', 'Login - Portal de Cursos')

@section('content')
<!-- Login Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-header bg-transparent text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-mortarboard-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0">Bem-vindo de volta!</h3>
                        <p class="text-muted">Faça login para acessar seus cursos</p>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Ops!</strong> Verifique os dados informados.
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('web.login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>E-mail
                                </label>
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       autofocus
                                       placeholder="seu@email.com">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-2"></i>Senha
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           autocomplete="current-password"
                                           placeholder="Sua senha">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Lembrar de mim
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    <i class="bi bi-question-circle me-1"></i>Esqueceu sua senha?
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-center py-3">
                        <p class="mb-0 text-muted">
                            Não tem uma conta?
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                                    Cadastre-se aqui
                                </a>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Quick Access -->
                <div class="text-center mt-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="card bg-white bg-opacity-10 border-0 text-white">
                                <div class="card-body py-3">
                                    <i class="bi bi-laptop display-6 mb-2"></i>
                                    <small class="d-block">Acesso Online</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-white bg-opacity-10 border-0 text-white">
                                <div class="card-body py-3">
                                    <i class="bi bi-award display-6 mb-2"></i>
                                    <small class="d-block">Certificados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-white bg-opacity-10 border-0 text-white">
                                <div class="card-body py-3">
                                    <i class="bi bi-headset display-6 mb-2"></i>
                                    <small class="d-block">Suporte 24/7</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        if (type === 'password') {
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    });
});
</script>
@endsection
