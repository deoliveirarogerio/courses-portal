@extends('admin.layouts.app')

@section('title', 'Editar Aula - Painel Administrativo')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Editar Aula</h2>
                <p class="text-muted mb-0">{{ $lesson->title }}</p>
            </div>
            <div>
                <a href="{{ route('admin.lessons.show', $lesson) }}" class="btn btn-outline-info me-2">
                    <i class="bi bi-eye me-2"></i>Visualizar
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
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="module_id" class="form-label">Módulo *</label>
                            <select class="form-select @error('module_id') is-invalid @enderror" id="module_id" name="module_id" required>
                                <option value="">Selecione um módulo</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" 
                                            {{ old('module_id', $lesson->module_id) == $module->id ? 'selected' : '' }}>
                                        {{ $module->title }} ({{ $module->course->title }})
                                    </option>
                                @endforeach
                            </select>
                            @error('module_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">Ordem *</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', $lesson->order) }}" min="1" required>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Título da Aula *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $lesson->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="video_url" class="form-label">URL do Vídeo</label>
                            <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                   id="video_url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Suporte para YouTube, Vimeo ou vídeos MP4 diretos
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="duration" class="form-label">Duração</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration', $lesson->duration) }}" 
                                   placeholder="ex: 15:30">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Conteúdo da Aula</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="6">{{ old('content', $lesson->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Descrição detalhada, objetivos e materiais da aula
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1" 
                                       {{ old('is_free', $lesson->is_free) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_free">
                                    Aula gratuita (preview)
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $lesson->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                                <option value="inactive" {{ old('status', $lesson->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                <option value="draft" {{ old('status', $lesson->status) == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash me-2"></i>Excluir Aula
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.lessons.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Preview do Vídeo -->
        @if($lesson->video_url)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-play-circle me-2"></i>Preview do Vídeo
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
                                class="w-100 rounded-bottom" 
                                src="{{ $embedUrl }}" 
                                title="Preview do Vídeo"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        @else
                            <video class="w-100 rounded-bottom" controls>
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Seu navegador não suporta o elemento de vídeo.
                            </video>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Informações da Aula -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informações
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong>Módulo:</strong><br>
                        <small class="text-muted">{{ $lesson->module->title ?? 'Não definido' }}</small>
                    </li>
                    <li class="mb-2">
                        <strong>Curso:</strong><br>
                        <small class="text-muted">{{ $lesson->module->course->title ?? 'Não definido' }}</small>
                    </li>
                    <li class="mb-2">
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview do vídeo ao alterar URL
    const videoUrlInput = document.getElementById('video_url');
    
    videoUrlInput.addEventListener('blur', function() {
        const url = this.value;
        if (url && (url.includes('youtube.com') || url.includes('youtu.be'))) {
            // Extrair ID do YouTube para validação
            const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)?\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
            const matches = url.match(regex);
            
            if (matches && matches[1]) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        }
    });
});
</script>
@endsection
