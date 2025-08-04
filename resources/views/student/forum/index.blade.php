@extends('student.layouts.dashboard')

@section('title', 'Fórum da Comunidade')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-chat-dots text-primary me-2"></i>
                        Fórum da Comunidade
                    </h2>
                    <p class="text-muted mb-0">Tire suas dúvidas, compartilhe conhecimento e conecte-se com outros alunos</p>
                </div>
                <a href="{{ route('student.forum.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Novo Tópico
                </a>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">{{ $categories->sum('topics_count') }}</h5>
                            <small>Total de Tópicos</small>
                        </div>
                        <i class="bi bi-chat-text fs-2 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">{{ $categories->count() }}</h5>
                            <small>Categorias Ativas</small>
                        </div>
                        <i class="bi bi-folder fs-2 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">{{ $recentTopics->count() }}</h5>
                            <small>Tópicos Recentes</small>
                        </div>
                        <i class="bi bi-clock-history fs-2 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Online</h5>
                            <small>Usuários Ativos</small>
                        </div>
                        <i class="bi bi-people fs-2 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Categorias -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-folder2-open me-2"></i>
                        Categorias do Fórum
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($categories as $category)
                        <div class="forum-category-item p-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="category-icon me-3" style="background-color: {{ $category->color }};">
                                            <i class="{{ $category->icon }} text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">
                                                <a href="{{ route('student.forum.category', $category->id) }}" 
                                                   class="text-decoration-none">
                                                    {{ $category->name }}
                                                </a>
                                            </h6>
                                            <p class="text-muted small mb-0">{{ $category->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $category->topics_count }} tópicos
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    @if($category->latestTopics->count() > 0)
                                        @php $latestTopic = $category->latestTopics->first(); @endphp
                                        <div class="latest-topic">
                                            <small class="text-muted">Último tópico:</small>
                                            <div>
                                                <a href="{{ route('student.forum.topic', $latestTopic->id) }}" 
                                                   class="text-decoration-none small">
                                                    {{ Str::limit($latestTopic->title, 40) }}
                                                </a>
                                            </div>
                                            <small class="text-muted">
                                                por {{ $latestTopic->user->name }} • 
                                                {{ $latestTopic->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    @else
                                        <small class="text-muted">Nenhum tópico ainda</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-folder-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Nenhuma categoria disponível</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Tópicos Recentes -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Tópicos Recentes
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse($recentTopics as $topic)
                        <div class="recent-topic-item p-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="avatar me-2">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px;">
                                        <span class="text-white small fw-bold">
                                            {{ substr($topic->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="{{ route('student.forum.topic', $topic->id) }}" 
                                           class="text-decoration-none">
                                            {{ Str::limit($topic->title, 35) }}
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center text-muted small">
                                        <span class="badge bg-light text-dark me-2">{{ $topic->category->name }}</span>
                                        <span>{{ $topic->user->name }}</span>
                                    </div>
                                    <small class="text-muted">{{ $topic->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-chat-dots fs-3 text-muted"></i>
                            <p class="text-muted mt-2 small">Nenhum tópico recente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.forum-category-item:hover {
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

.recent-topic-item:hover {
    background-color: #f8f9fa;
}

.latest-topic a:hover {
    color: #0d6efd !important;
}
</style>
@endsection