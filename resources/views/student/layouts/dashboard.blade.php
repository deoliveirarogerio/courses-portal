<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('web/css/dash.css') }}" rel="stylesheet">
    <title>@yield('title', 'Dashboard - Portal de Cursos')</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar" id="sidebar">
                    <!-- Logo -->
                    <div class="p-4 text-center border-bottom border-white border-opacity-25">
                        <h4 class="text-white mb-0">
                            <i class="bi bi-mortarboard-fill me-2"></i>
                            Portal de Cursos
                        </h4>
                        <small class="text-white-50">Dashboard do Aluno</small>
                    </div>

                    <!-- User Info -->
                    <div class="p-4 text-center border-bottom border-white border-opacity-25">
                        <div class="user-avatar mx-auto mb-2">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <h6 class="text-white mb-1">{{ auth()->user()->name ?? 'Usuário' }}</h6>
                        <small class="text-white-50">{{ auth()->user()->email ?? 'email@exemplo.com' }}</small>
                    </div>

                    <!-- Navigation -->
                    <nav class="nav flex-column py-3">
                        <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                            <i class="bi bi-speedometer2 me-3"></i>Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('student.courses*') ? 'active' : '' }}" href="{{ route('student.courses') }}">
                            <i class="bi bi-book me-3"></i>Meus Cursos
                        </a>
                        <a class="nav-link {{ request()->routeIs('student.certificates*') ? 'active' : '' }}" href="{{ route('student.certificates') }}">
                            <i class="bi bi-award me-3"></i>Certificados
                        </a>
                        <a class="nav-link {{ request()->routeIs('student.progress*') ? 'active' : '' }}" href="{{ route('student.progress') }}">
                            <i class="bi bi-graph-up me-3"></i>Progresso
                        </a>
                        <a class="nav-link {{ request()->routeIs('student.profile*') ? 'active' : '' }}" href="{{ route('student.profile') }}">
                            <i class="bi bi-person me-3"></i>Perfil
                        </a>

                        <hr class="border-white border-opacity-25 mx-3">

                        <a class="nav-link" href="{{ route('web.home') }}" target="_blank">
                            <i class="bi bi-house me-3"></i>Voltar ao Site
                        </a>
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-3"></i>Sair
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <div class="main-content">
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-expand-lg top-navbar px-4">
                        <button class="btn btn-outline-secondary d-md-none me-3" type="button" id="sidebarToggle">
                            <i class="bi bi-list"></i>
                        </button>

                        <div class="navbar-nav ms-auto">
                            <!-- Notifications -->
                            <div class="nav-item dropdown">
                                <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-bell fs-5"></i>
                                    <span class="notification-badge">3</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header">Notificações</h6></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="bi bi-info-circle text-primary me-2"></i>
                                        Novo curso disponível
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Certificado emitido
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="bi bi-clock text-warning me-2"></i>
                                        Lembrete de aula
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-center" href="#">Ver todas</a></li>
                                </ul>
                            </div>

                            <!-- User Menu -->
                            <div class="nav-item dropdown">
                                <a class="nav-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="user-avatar me-2">
                                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="d-none d-lg-inline">{{ auth()->user()->name ?? 'Usuário' }}</span>
                                    <i class="bi bi-chevron-down ms-2"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('student.profile') }}">
                                        <i class="bi bi-person me-2"></i>Meu Perfil
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="bi bi-gear me-2"></i>Configurações
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Sair
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                    <!-- Page Content -->
                    <div class="p-4">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
