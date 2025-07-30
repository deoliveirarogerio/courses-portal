@extends('admin.layouts.app')

@section('title', 'Cursos - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Gerenciar Cursos</h2>
                <p class="text-muted mb-0">Crie, edite e gerencie os cursos da plataforma</p>
            </div>
            <div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Novo Curso
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($courses->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Título</th>
                            <th>Instrutor</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th>Módulos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>
                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" 
                                         class="rounded" width="50" height="50" style="object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $course->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                </td>
                                <td>{{ $course->instructor->name ?? 'Não informado' }}</td>
                                <td>
                                    @if($course->price == 0)
                                        <span class="badge bg-success">Gratuito</span>
                                    @else
                                        R$ {{ number_format($course->price, 2, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $course->status_color }}">
                                        {{ $course->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $course->modules->count() }} módulos</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.courses.show', $course) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.courses.edit', $course) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.courses.destroy', $course) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este curso?')">
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
                {{ $courses->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-book fs-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Nenhum curso cadastrado</h5>
                <p class="text-muted">Comece criando seu primeiro curso!</p>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Criar Primeiro Curso
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 