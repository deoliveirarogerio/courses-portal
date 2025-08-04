@extends('student.layouts.dashboard')

@section('title', $category->name . ' - Fórum')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('student.forum.index') }}">Fórum</a>
            </li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Header da Categoria -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="category-icon me-3" style="background-color: {{ $category->color }};">
                                <i class="{{ $category->icon }} text-white"></i>
                            </div>
                            <div>
                                <h3 class="mb-1">{{ $category->name }}</h3>
                                <p class="text-muted mb-0">{{ $category->description }}</p>
                            </div>
                        </div>
                        <a href="{{ route('student.forum.create') }}?category={{ $category->id }}" 
                           class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Novo Tópico
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Tópicos -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-chat-text me-2"></i>
                    Tópicos ({{ $topics->total() }})
                </h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active">
                        <i class="bi bi-sort-down me-1"></i>Recentes
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-eye me-1"></i>Mais Vistos
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @forelse($topics as $topic)
                <div class="topic-item p-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start">
                                <!-- Avatar do usuário -->
                                <div class="avatar me-3">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold">
                                            {{ substr($topic->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <!-- Título e badges -->
                                    <div class="d-flex align-items-center mb-1">
                                        @if($topic->is_pinned)
                                            <i class="bi bi-pin-fill text-warning me-1" title="Fixado"></i>
                                        @endif
                                        @if($topic->is_locked)
                                            <i class="bi bi-lock-fill text-danger me-1" title="Bloqueado"></i>
                                        @endif
                                        @if($topic->is_solved)
                                            <i class="bi bi-check-circle-fill text-success me-1" title="Resolvido"></i>
                                        @endif
                                        
                                        <h6 class="mb-0">
                                            <a href="{{ route('student.forum.topic', $topic->id) }}" 
                                               class="text-decoration-none">
                                                {{ $topic->title }}
                                            </a>
                                        </h6>
                                    </div>
                                    
                                    <!-- Informações do autor -->
                                    <div class="text-muted small">
                                        por <strong>{{ $topic->user->name }}</strong> • 
                                        {{ $topic->created_at->diffForHumans() }}
                                        @if($topic->course)
                                            • <span class="badge bg-light text-dark">{{ $topic->course->title }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2 text-center">
                            <div class="topic-stats">
                                <div class="d-flex justify-content-center gap-3">
                                    <div class="text-center">
                                        <div class="fw-bold text-primary">{{ $topic->posts->count() }}</div>
                                        <small class="text-muted">respostas</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-bold text-info">{{ $topic->views_count }}</div>
                                        <small class="text-muted">visualizações</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            @if($topic->latestPost)
                                <div class="latest-reply text-end">
                                    <small class="text-muted">Última resposta:</small>
                                    <div class="small">
                                        <strong>{{ $topic->latestPost->user->name }}</strong>
                                    </div>
                                    <small class="text-muted">{{ $topic->latestPost->created_at->diffForHumans() }}</small>
                                </div>
                            @else
                                <div class="text-center">
                                    <small class="text-muted">Sem respostas</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-chat-dots fs-1 text-muted"></i>
                    <h5 class="text-muted mt-3">Nenhum tópico encontrado</h5>
                    <p class="text-muted">Seja o primeiro a iniciar uma discussão nesta categoria!</p>
                    <a href="{{ route('student.forum.create') }}?category={{ $category->id }}" 
                       class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Criar Primeiro Tópico
                    </a>
                </div>
            @endforelse
        </div>
        
        @if($topics->hasPages())
            <div class="card-footer">
                {{ $topics->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.topic-item:hover {
    background-color: #f8f9fa;
}

.category-icon {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.topic-stats .fw-bold {
    font-size: 1.1rem;
}

.latest-reply {
    font-size: 0.85rem;
}
</style>
@endsection