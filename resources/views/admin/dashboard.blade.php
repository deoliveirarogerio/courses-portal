@extends('admin.layouts.app')

@section('title', 'Dashboard - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Visão geral da plataforma</p>
    </div>
</div>

<!-- Estatísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total de Cursos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCourses }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-book fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total de Usuários
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total de Módulos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalModules }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-collection fs-2 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total de Aulas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLessons }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-play-circle fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0">Ações Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle me-2"></i>Criar Curso
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.modules.create') }}" class="btn btn-info w-100">
                            <i class="bi bi-collection me-2"></i>Criar Módulo
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.lessons.create') }}" class="btn btn-success w-100">
                            <i class="bi bi-play-circle me-2"></i>Criar Aula
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-warning w-100">
                            <i class="bi bi-person-plus me-2"></i>Criar Usuário
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimos Cursos -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Últimos Cursos</h5>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
            </div>
            <div class="card-body">
                @if($recentCourses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Instrutor</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCourses as $course)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.courses.show', $course) }}" 
                                               class="text-decoration-none">
                                                {{ $course->title }}
                                            </a>
                                        </td>
                                        <td>{{ $course->instructor->name ?? 'Não informado' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $course->status_color }}">
                                                {{ $course->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $course->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-book fs-1 text-muted"></i>
                        <h6 class="mt-3 text-muted">Nenhum curso cadastrado</h6>
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Criar Primeiro Curso
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0">Últimos Usuários</h5>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <span class="badge bg-{{ $user->type == 'admin' ? 'danger' : ($user->type == 'instrutor' ? 'warning' : 'primary') }}">
                                    {{ ucfirst($user->type) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Todos os Usuários
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people fs-1 text-muted"></i>
                        <h6 class="mt-3 text-muted">Nenhum usuário cadastrado</h6>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Criar Primeiro Usuário
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 