@extends('web._theme')

@section('title', 'Cadastro - Portal de Cursos')

@section('content')
<!-- Register Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-header bg-transparent text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-0">Crie sua conta</h3>
                        <p class="text-muted">Junte-se a milhares de estudantes</p>
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

                        <form method="POST" action="{{ route('web.register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Nome Completo
                                    </label>
                                    <input type="text"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autocomplete="name"
                                           autofocus
                                           placeholder="Seu nome completo">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
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
                                           placeholder="seu@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-2"></i>Senha
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               required
                                               autocomplete="new-password"
                                               placeholder="Mínimo 8 caracteres">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <small class="text-muted">Mínimo 8 caracteres</small>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill me-2"></i>Confirmar Senha
                                    </label>
                                    <input type="password"
                                           class="form-control form-control-lg"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required
                                           autocomplete="new-password"
                                           placeholder="Confirme sua senha">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Eu concordo com os
                                        <a href="#" class="text-primary text-decoration-none">Termos de Uso</a>
                                        e
                                        <a href="#" class="text-primary text-decoration-none">Política de Privacidade</a>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Desejo receber novidades e promoções por e-mail
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>Criar Conta
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                <i class="bi bi-shield-check me-1"></i>
                                Seus dados estão seguros conosco
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-center py-3">
                        <p class="mb-0 text-muted">
                            Já tem uma conta?
                            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                                Faça login aqui
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Benefits -->
                <div class="text-center mt-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-white bg-opacity-10 border-0 text-white">
                                <div class="card-body py-3">
                                    <i class="bi bi-infinity display-6 mb-2"></i>
                                    <small class="d-block">Acesso Vitalício</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-white bg-opacity-10 border-0 text-white">
                                <div class="card-body py-3">
                                    <i class="bi bi-trophy display-6 mb-2"></i>
                                    <small class="d-block">Certificados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-white bg-opacity-10 border-0 text-white">
                                <div class="card-body py-3">
                                    <i class="bi bi-people display-6 mb-2"></i>
                                    <small class="d-block">Comunidade</small>
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

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = getPasswordStrength(password);

        // Remove existing classes
        this.classList.remove('is-valid', 'is-invalid');

        if (password.length > 0) {
            if (strength >= 3) {
                this.classList.add('is-valid');
            } else if (strength < 2) {
                this.classList.add('is-invalid');
            }
        }
    });

    passwordConfirm.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirm = this.value;

        this.classList.remove('is-valid', 'is-invalid');

        if (confirm.length > 0) {
            if (password === confirm) {
                this.classList.add('is-valid');
            } else {
                this.classList.add('is-invalid');
            }
        }
    });

    function getPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        return strength;
    }
});
</script>
@endsection
