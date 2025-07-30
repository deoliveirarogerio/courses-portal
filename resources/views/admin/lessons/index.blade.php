@extends('admin.layouts.app')

@section('title', 'Aulas - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Gerenciar Aulas</h2>
                <p class="text-muted mb-0">Organize o conteúdo das aulas</p>
            </div>
            <div>
                <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Nova Aula
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($lessons->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Módulo</th>
                            <th>Curso</th>
                            <th>Duração</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lessons as $lesson)
                            <tr>
                                <td>{{ $lesson->id }}</td>
                                <td>
                                    <strong>{{ $lesson->title }}</strong>
                                    @if($lesson->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($lesson->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.modules.show', $lesson->module) }}" 
                                       class="text-decoration-none">
                                        {{ $lesson->module->title }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.courses.show', $lesson->module->course) }}" 
                                       class="text-decoration-none">
                                        {{ $lesson->module->course->title }}
                                    </a>
                                </td>
                                <td>{{ $lesson->duration ?? 'Não informado' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $lesson->order }}</span>
                                </td>
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $lessons->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-play-circle fs-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Nenhuma aula cadastrada</h5>
                <p class="text-muted">Comece criando sua primeira aula!</p>
                <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Criar Primeira Aula
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 