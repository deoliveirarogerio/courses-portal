@extends('admin.layouts.app')

@section('title', 'Visualizar Aula - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">{{ $lesson->title }}</h2>
                <p class="text-muted mb-0">
                    {{ $lesson->module->title ?? 'Módulo não definido' }} - 
                    {{ $lesson->module->course->title ?? 'Curso não definido' }}
                </p>
            </div>
            <div>
                <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil me-2"></i>Editar
                </a>
                <a href="{{ route('admin.lessons.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Player de Vídeo -->
        @if($lesson->video_url)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-play-circle me-2"></i>Vídeo da Aula
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9">
                        @php
                            $videoUrl = $lesson->video_url;
                            $isYouTube = strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false;
                            
                            if ($isYouTube) {
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)?\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                                $youtubeId = $matches[1] ?? '';
                                $embedUrl = "https://www.youtube.com/embed/{$youtubeId}?rel=0&modestbranding=1&showinfo=0";
                            }
                        @endphp
                        
                        @if($isYouTube && !empty($youtubeId))
                            <iframe 
                                class="w-100" 
                                src="{{ $embedUrl }}" 
                                title="Vídeo da Aula"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        @else
                            <video class="w-100" controls>
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Seu navegador não suporta o elemento de vídeo.
                            </video>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Conteúdo da Aula -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-file-text me-2"></i>Conteúdo da Aula
                </h5>
            </div>
            <div class="card-body">
                @if($lesson->description)
                    <div class="mb-3">
                        <h6 class="fw-bold">Descrição:</h6>
                        <p class="text-muted">{{ $lesson->description }}</p>
                    </div>
                @endif

                @if($lesson->content)
                    <div class="mb-0">
                        <h6 class="fw-bold">Conteúdo Detalhado:</h6>
                        <div class="content-text">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    </div>
                @else
                    <p class="text-muted mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Nenhum conteúdo detalhado foi adicionado para esta aula.
                    </p>
                @endif
            </div>
        </div>

        <!-- Estatísticas da Aula -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>Estatísticas
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary mb-1">{{ $lesson->views_count ?? 0 }}</h4>
                            <small class="text-muted">Visualizações</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success mb-1">{{ $lesson->completed_count ?? 0 }}</h4>
                            <small class="text-muted">Concluídas</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-1">{{ $lesson->duration ?? '--' }}</h4>
                            <small class="text-muted">Duração</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning mb-1">{{ $lesson->order }}</h4>
                            <small class="text-muted">Ordem</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Informações da Aula -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informações
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <strong>Status:</strong><br>
                        <span class="badge bg-{{ $lesson->status == 'active' ? 'success' : ($lesson->status == 'inactive' ? 'danger' : 'warning') }}">
                            {{ ucfirst($lesson->status) }}
                        </span>
                    </li>
                    <li class="mb-3">
                        <strong>Tipo:</strong><br>
                        @if($lesson->is_free)
                            <span class="badge bg-success">
                                <i class="bi bi-unlock me-1"></i>Gratuita
                            </span>
                        @else
                            <span class="badge bg-primary">
                                <i class="bi bi-lock me-1"></i>Premium
                            </span>
                        @endif
                    </li>
                    <li class="mb-3">
                        <strong>Módulo:</strong><br>
                        <small class="text-muted">{{ $lesson->module->title ?? 'Não definido' }}</small>
                    </li>
                    <li class="mb-3">
                        <strong>Curso:</strong><br>
                        <small class="text-muted">{{ $lesson->module->course->title ?? 'Não definido' }}</small>
                    </li>
                    <li class="mb-3">
                        <strong>Instrutor:</strong><br>
                        <small class="text-muted">{{ $lesson->module->course->instructor->name ?? 'Não definido' }}</small>
                    </li>
                    <li class="mb-3">
                        <strong>URL do Vídeo:</strong><br>
                        @if($lesson->video_url)
                            <a href="{{ $lesson->video_url }}" target="_blank" class="text-decoration-none">
                                <small class="text-primary">
                                    <i class="bi bi-link-45deg me-1"></i>
                                    {{ Str::limit($lesson->video_url, 30) }}
                                </small>
                            </a>
                        @else
                            <small class="text-muted">Não definido</small>
                        @endif
                    </li>
                    <li class="mb-3">
                        <strong>Criado em:</strong><br>
                        <small class="text-muted">{{ $lesson->created_at->format('d/m/Y H:i') }}</small>
                    </li>
                    <li class="mb-0">
                        <strong>Atualizado em:</strong><br>
                        <small class="text-muted">{{ $lesson->updated_at->format('d/m/Y H:i') }}</small>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Editar Aula
                    </a>
                    
                    @if($lesson->module)
                        <a href="{{ route('admin.modules.show', $lesson->module) }}" class="btn btn-outline-info">
                            <i class="bi bi-collection me-2"></i>Ver Módulo
                        </a>
                    @endif
                    
                    @if($lesson->module && $lesson->module->course)
                        <a href="{{ route('admin.courses.show', $lesson->module->course) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-book me-2"></i>Ver Curso
                        </a>
                    @endif
                    
                    <hr class="my-2">
                    
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-2"></i>Excluir Aula
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a aula <strong>"{{ $lesson->title }}"</strong>?</p>
                <p class="text-danger mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.content-text {
    line-height: 1.6;
    color: #495057;
}

.content-text p {
    margin-bottom: 1rem;
}
</style>
@endsection
