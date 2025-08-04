@extends('student.layouts.dashboard')

@section('title', $topic->title . ' - Fórum')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('student.forum.index') }}">Fórum</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('student.forum.category', $topic->category->id) }}">{{ $topic->category->name }}</a>
            </li>
            <li class="breadcrumb-item active">{{ Str::limit($topic->title, 50) }}</li>
        </ol>
    </nav>

    <!-- Cabeçalho do Tópico -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-2">
                        @if($topic->is_pinned)
                            <span class="badge bg-warning me-2">
                                <i class="bi bi-pin-fill me-1"></i>Fixado
                            </span>
                        @endif
                        @if($topic->is_locked)
                            <span class="badge bg-danger me-2">
                                <i class="bi bi-lock-fill me-1"></i>Bloqueado
                            </span>
                        @endif
                        @if($topic->is_solved)
                            <span class="badge bg-success me-2">
                                <i class="bi bi-check-circle-fill me-1"></i>Resolvido
                            </span>
                        @endif
                        @if($topic->course)
                            <span class="badge bg-primary me-2">
                                <i class="bi bi-book me-1"></i>{{ $topic->course->title }}
                            </span>
                        @endif
                    </div>
                    <h4 class="mb-0">{{ $topic->title }}</h4>
                </div>
                <div class="topic-actions">
                    @if(!$topic->is_locked)
                        <button class="btn btn-primary btn-sm" onclick="scrollToReply()">
                            <i class="bi bi-reply me-1"></i>Responder
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="topic-content">
                        {!! nl2br(e($topic->content)) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="topic-stats">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number text-primary">{{ $posts->total() }}</div>
                                    <div class="stat-label">Respostas</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number text-info">{{ $topic->views_count }}</div>
                                    <div class="stat-label">Visualizações</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <div class="stat-number text-success">0</div>
                                    <div class="stat-label">Curtidas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Autor do Tópico -->
            <div class="topic-author mt-3 pt-3 border-top">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 48px; height: 48px;">
                            <span class="text-white fw-bold fs-5">
                                {{ substr($topic->user->name, 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $topic->user->name }}</h6>
                        <small class="text-muted">
                            @if($topic->user->type === 'instrutor')
                                <i class="bi bi-mortarboard text-warning me-1"></i>Instrutor
                            @else
                                <i class="bi bi-person text-primary me-1"></i>Aluno
                            @endif
                            • Criado em {{ $topic->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Respostas -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-chat-left-text me-2"></i>
                Respostas ({{ $posts->total() }})
            </h5>
        </div>
        <div class="card-body p-0">
            @forelse($posts as $post)
                <div class="forum-post p-4 border-bottom" id="post-{{ $post->id }}">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <!-- Avatar e info do usuário -->
                            <div class="user-info">
                                <div class="avatar mb-2">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                         style="width: 64px; height: 64px;">
                                        <span class="text-white fw-bold fs-4">
                                            {{ substr($post->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <h6 class="mb-1">{{ $post->user->name }}</h6>
                                <small class="text-muted">
                                    @if($post->user->type === 'instrutor')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-mortarboard me-1"></i>Instrutor
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            <i class="bi bi-person me-1"></i>Aluno
                                        </span>
                                    @endif
                                </small>
                                @if($post->is_solution)
                                    <div class="mt-2">
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>Solução
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="post-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $post->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    <div class="post-actions">
                                        <button class="btn btn-sm btn-outline-primary" onclick="likePost({{ $post->id }})">
                                            <i class="bi bi-heart me-1"></i>
                                            <span id="likes-{{ $post->id }}">{{ $post->likes_count }}</span>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="quotePost({{ $post->id }})">
                                            <i class="bi bi-quote me-1"></i>Citar
                                        </button>
                                        @if($post->user_id === auth()->id() || auth()->user()->type === 'instrutor')
                                            @if(!$post->is_solution && !$topic->is_solved)
                                                <button class="btn btn-sm btn-outline-success" onclick="markAsSolution({{ $post->id }})">
                                                    <i class="bi bi-check-circle me-1"></i>Marcar como Solução
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="post-text">
                                    {!! nl2br(e($post->content)) !!}
                                </div>
                                
                                @if($post->attachments->count() > 0)
                                    <div class="post-attachments mt-3">
                                        <h6><i class="bi bi-paperclip me-1"></i>Anexos:</h6>
                                        <div class="row">
                                            @foreach($post->attachments as $attachment)
                                                <div class="col-md-6 mb-2">
                                                    <div class="attachment-item p-2 border rounded">
                                                        <i class="bi bi-file-earmark me-2"></i>
                                                        <a href="{{ Storage::url($attachment->path) }}" 
                                                           target="_blank" class="text-decoration-none">
                                                            {{ $attachment->original_name }}
                                                        </a>
                                                        <small class="text-muted">({{ number_format($attachment->size / 1024, 1) }} KB)</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-chat-left-text fs-1 text-muted"></i>
                    <h5 class="text-muted mt-3">Nenhuma resposta ainda</h5>
                    <p class="text-muted">Seja o primeiro a responder este tópico!</p>
                </div>
            @endforelse
        </div>
        
        @if($posts->hasPages())
            <div class="card-footer">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

    <!-- Formulário de Resposta -->
    @if(!$topic->is_locked)
        <div class="card mt-4" id="reply-form">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-reply me-2"></i>
                    Responder ao Tópico
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('student.forum.reply', $topic->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="reply_content" class="form-label">Sua Resposta *</label>
                        <div class="editor-toolbar mb-2">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" onclick="formatReplyText('bold')">
                                    <i class="bi bi-type-bold"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="formatReplyText('italic')">
                                    <i class="bi bi-type-italic"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="insertReplyLink()">
                                    <i class="bi bi-link"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="insertReplyCode()">
                                    <i class="bi bi-code"></i>
                                </button>
                            </div>
                        </div>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="reply_content" 
                                  name="content" 
                                  rows="6"
                                  placeholder="Digite sua resposta..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reply_attachments" class="form-label">Anexos (opcional)</label>
                        <input type="file" 
                               class="form-control" 
                               id="reply_attachments" 
                               name="attachments[]" 
                               multiple
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>
                            Enviar Resposta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            <i class="bi bi-lock me-2"></i>
            Este tópico está bloqueado e não aceita mais respostas.
        </div>
    @endif
</div>

<style>
.forum-post:hover {
    background-color: #f8f9fa;
}

.stat-item {
    padding: 10px;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
}

.user-info {
    position: sticky;
    top: 20px;
}

.post-content {
    min-height: 100px;
}

.attachment-item {
    background-color: #f8f9fa;
}

.attachment-item:hover {
    background-color: #e9ecef;
}
</style>

<script>
function scrollToReply() {
    document.getElementById('reply-form').scrollIntoView({ behavior: 'smooth' });
    document.getElementById('reply_content').focus();
}

function likePost(postId) {
    // Implementar funcionalidade de curtir
    console.log('Curtir post:', postId);
}

function quotePost(postId) {
    const postElement = document.getElementById(`post-${postId}`);
    const postContent = postElement.querySelector('.post-text').textContent.trim();
    const userName = postElement.querySelector('.user-info h6').textContent.trim();
    
    const replyTextarea = document.getElementById('reply_content');
    const quote = `> **${userName} disse:**\n> ${postContent}\n\n`;
    
    replyTextarea.value = quote + replyTextarea.value;
    scrollToReply();
}

function markAsSolution(postId) {
    if (confirm('Marcar esta resposta como solução?')) {
        // Implementar AJAX para marcar como solução
        console.log('Marcar como solução:', postId);
    }
}

// Funções de formatação para resposta
function formatReplyText(command) {
    const textarea = document.getElementById('reply_content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let formattedText = '';
    switch(command) {
        case 'bold':
            formattedText = `**${selectedText}**`;
            break;
        case 'italic':
            formattedText = `*${selectedText}*`;
            break;
    }
    
    if (formattedText) {
        textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
    }
}

function insertReplyLink() {
    const url = prompt('Digite a URL:');
    const text = prompt('Digite o texto do link:') || url;
    
    if (url) {
        const textarea = document.getElementById('reply_content');
        const start = textarea.selectionStart;
        const linkText = `[${text}](${url})`;
        
        textarea.value = textarea.value.substring(0, start) + linkText + textarea.value.substring(textarea.selectionEnd);
        textarea.focus();
        textarea.setSelectionRange(start + linkText.length, start + linkText.length);
    }
}

function insertReplyCode() {
    const textarea = document.getElementById('reply_content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    const codeText = selectedText ? `\`${selectedText}\`` : '```\n\n```';
    
    textarea.value = textarea.value.substring(0, start) + codeText + textarea.value.substring(end);
    textarea.focus();
    
    if (selectedText) {
        textarea.setSelectionRange(start + codeText.length, start + codeText.length);
    } else {
        textarea.setSelectionRange(start + 4, start + 4);
    }
}
</script>
@endsection