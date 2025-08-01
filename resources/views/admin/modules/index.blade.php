@extends('admin.layouts.app')

@section('title', 'Módulos - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Gerenciar Módulos</h2>
                <p class="text-muted mb-0">Organize o conteúdo dos cursos em módulos</p>
            </div>
            <div>
                <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Novo Módulo
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($modules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Curso</th>
                            <th>Descrição</th>
                            <th>Ordem</th>
                            <th>Aulas</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ $module->id }}</td>
                                <td>
                                    <strong>{{ $module->title }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('admin.courses.show', $module->course) }}" 
                                       class="text-decoration-none">
                                        {{ $module->course->title }}
                                    </a>
                                </td>
                                <td>
                                    {{ Str::limit($module->description, 50) }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $module->order }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $module->lessons->count() }} aulas</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.modules.show', $module) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.modules.edit', $module) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.modules.destroy', $module) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este módulo?')">
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
                {{ $modules->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-collection fs-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Nenhum módulo cadastrado</h5>
                <p class="text-muted">Comece criando seu primeiro módulo!</p>
                <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Criar Primeiro Módulo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 