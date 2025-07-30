@extends('admin.layouts.app')

@section('title', 'Detalhes do Módulo - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Detalhes do Módulo</h2>
                <p class="text-muted mb-0">{{ $module->title }}</p>
            </div>
            <div>
                <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil me-2"></i>Editar
                </a>
                <a href="{{ route('admin.modules.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="fw-bold mb-0">Informações do Módulo</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Título:</strong> {{ $module->title }}</p>
                        <p><strong>Curso:</strong> 
                            <a href="{{ route('admin.courses.show', $module->course) }}" 
                               class="text-decoration-none">
                                {{ $module->course->title }}
                            </a>
                        </p>
                        <p><strong>Ordem:</strong> {{ $module->order }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Criado em:</strong> {{ $module->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Atualizado em:</strong> {{ $module->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($module->description)
                    <div class="mt-3">
                        <h6><strong>Descrição:</strong></h6>
                        <p>{{ $module->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Aulas do Módulo -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Aulas do Módulo</h5>
                <a href="{{ route('admin.lessons.create') }}?module_id={{ $module->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Adicionar Aula
                </a>
            </div>
            <div class="card-body">
                @if($module->lessons->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ordem</th>
                                    <th>Título</th>
                                    <th>Duração</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($module->lessons as $lesson)
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">{{ $lesson->order }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $lesson->title }}</strong>
                                            @if($lesson->description)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($lesson->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $lesson->duration ?? 'Não informado' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.lessons.show', $lesson) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.lessons.edit', $lesson) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Tem certeza que deseja excluir esta aula?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-play-circle fs-1 text-muted"></i>
                        <h6 class="mt-3 text-muted">Nenhuma aula cadastrada</h6>
                        <p class="text-muted">Adicione aulas para organizar o conteúdo do módulo.</p>
                        <a href="{{ route('admin.lessons.create') }}?module_id={{ $module->id }}" 
                           class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Adicionar Primeira Aula
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Estatísticas -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="fw-bold mb-0">Estatísticas</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="fw-bold text-primary">{{ $module->lessons->count() }}</h4>
                        <small class="text-muted">Aulas</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold text-success">{{ $module->course->modules->count() }}</h4>
                        <small class="text-muted">Módulos no Curso</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="card">
            <div class="card-header">
                <h6 class="fw-bold mb-0">Ações Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.lessons.create') }}?module_id={{ $module->id }}" 
                       class="btn btn-outline-success">
                        <i class="bi bi-play-circle me-2"></i>Adicionar Aula
                    </a>
                    <a href="{{ route('admin.modules.edit', $module) }}" 
                       class="btn btn-outline-warning">
                        <i class="bi bi-pencil me-2"></i>Editar Módulo
                    </a>
                    <a href="{{ route('admin.courses.show', $module->course) }}" 
                       class="btn btn-outline-primary">
                        <i class="bi bi-book me-2"></i>Ver Curso
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 