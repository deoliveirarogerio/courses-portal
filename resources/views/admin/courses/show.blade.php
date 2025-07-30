@extends('admin.layouts.app')

@section('title', 'Detalhes do Curso - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Detalhes do Curso</h2>
                <p class="text-muted mb-0">{{ $course->title }}</p>
            </div>
            <div>
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil me-2"></i>Editar
                </a>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
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
                <h5 class="fw-bold mb-0">Informações do Curso</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Título:</strong> {{ $course->title }}</p>
                        <p><strong>Instrutor:</strong> {{ $course->instructor ?? 'Não informado' }}</p>
                        <p><strong>Duração:</strong> {{ $course->duration ?? 'Não informado' }}</p>
                        <p><strong>Nível:</strong> {{ $course->difficulty_level_label }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Preço:</strong> 
                            @if($course->price == 0)
                                <span class="badge bg-success">Gratuito</span>
                            @else
                                R$ {{ number_format($course->price, 2, ',', '.') }}
                            @endif
                        </p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $course->status_color }}">{{ $course->status_label }}</span>
                        </p>
                        <p><strong>Máximo de Alunos:</strong> {{ $course->max_students }}</p>
                        <p><strong>Vagas Restantes:</strong> {{ $course->remaining_slots }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <h6><strong>Descrição:</strong></h6>
                    <p>{{ $course->description }}</p>
                </div>

                @if($course->curriculum)
                    <div class="mt-3">
                        <h6><strong>Currículo:</strong></h6>
                        <p>{{ $course->curriculum }}</p>
                    </div>
                @endif

                @if($course->image)
                    <div class="mt-3">
                        <h6><strong>Imagem:</strong></h6>
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" 
                             class="img-thumbnail" style="max-width: 300px;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Módulos do Curso -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Módulos do Curso</h5>
                <a href="{{ route('admin.modules.create') }}?course_id={{ $course->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Adicionar Módulo
                </a>
            </div>
            <div class="card-body">
                @if($course->modules->count() > 0)
                    <div class="accordion" id="modulesAccordion">
                        @foreach($course->modules as $module)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $module->id }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                            type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $module->id }}">
                                        {{ $module->title }}
                                        <span class="badge bg-info ms-2">{{ $module->lessons->count() }} aulas</span>
                                    </button>
                                </h2>
                                <div id="collapse{{ $module->id }}" 
                                     class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                     data-bs-parent="#modulesAccordion">
                                    <div class="accordion-body">
                                        @if($module->description)
                                            <p class="text-muted">{{ $module->description }}</p>
                                        @endif
                                        
                                        @if($module->lessons->count() > 0)
                                            <ul class="list-group list-group-flush">
                                                @foreach($module->lessons as $lesson)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>{{ $lesson->title }}</span>
                                                        <span class="badge bg-light text-muted">{{ $lesson->duration }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">Nenhuma aula cadastrada neste módulo.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-collection fs-1 text-muted"></i>
                        <h6 class="mt-3 text-muted">Nenhum módulo cadastrado</h6>
                        <p class="text-muted">Adicione módulos para organizar o conteúdo do curso.</p>
                        <a href="{{ route('admin.modules.create') }}?course_id={{ $course->id }}" 
                           class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Adicionar Primeiro Módulo
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
                        <h4 class="fw-bold text-primary">{{ $course->modules->count() }}</h4>
                        <small class="text-muted">Módulos</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold text-success">{{ $course->modules->sum(function($module) { return $module->lessons->count(); }) }}</h4>
                        <small class="text-muted">Aulas</small>
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
                    <a href="{{ route('admin.modules.create') }}?course_id={{ $course->id }}" 
                       class="btn btn-outline-primary">
                        <i class="bi bi-collection me-2"></i>Adicionar Módulo
                    </a>
                    <a href="{{ route('admin.lessons.create') }}?course_id={{ $course->id }}" 
                       class="btn btn-outline-success">
                        <i class="bi bi-play-circle me-2"></i>Adicionar Aula
                    </a>
                    <a href="{{ route('admin.courses.edit', $course) }}" 
                       class="btn btn-outline-warning">
                        <i class="bi bi-pencil me-2"></i>Editar Curso
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 