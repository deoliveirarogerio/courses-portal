<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('web/css/style.css') }}" rel="stylesheet">
    <title>@yield('title', 'Portal de Cursos')</title>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('web.home') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>Portal de Cursos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.home') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.courses.index') }}">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.about') }}">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.contact') }}">Contato</a>
                    </li>
                </ul>
                <!-- Authentication Links -->
                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('web.login') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="{{ route('web.register') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-person-plus me-1"></i>Cadastro
                        </a>
                    @else
                        <div class="dropdown">
                            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('student.profile') }}">
                                    <i class="bi bi-person me-2"></i>Meu Perfil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sair
                                </a></li>
                            </ul>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-mortarboard-fill me-2"></i>Portal de Cursos</h5>
                    <p>Sua plataforma de aprendizado online com os melhores cursos do mercado.</p>
                </div>
                <div class="col-md-4">
                    <h5>Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('web.courses.index') }}" class="text-white-50">Cursos</a></li>
                        <li><a href="{{ route('web.about') }}" class="text-white-50">Sobre Nós</a></li>
                        <li><a href="{{ route('web.contact') }}" class="text-white-50">Contato</a></li>
                        <li><a href="{{ route('web.contact') }}" class="text-white-50">Suporte</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contato</h5>
                    <p class="text-white-50">
                        <i class="bi bi-envelope me-2"></i>contato@portaldecursos.com<br>
                        <i class="bi bi-telephone me-2"></i>(11) 9999-9999
                    </p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Portal de Cursos. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
