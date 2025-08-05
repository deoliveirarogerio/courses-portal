@extends('student.layouts.dashboard')

@section('title', 'Criar Novo Tópico - Fórum')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('student.forum.index') }}">Fórum</a>
            </li>
            <li class="breadcrumb-item active">Novo Tópico</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>
                        Criar Novo Tópico
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.forum.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Categoria -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">
                                <i class="bi bi-folder me-1"></i>
                                Categoria *
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', request('category')) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Título -->
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <i class="bi bi-chat-text me-1"></i>
                                Título do Tópico *
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Digite um título claro e descritivo"
                                   maxlength="255"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <span id="titleCounter">0</span>/255 caracteres
                            </div>
                        </div>

                        <!-- Conteúdo -->
                        <div class="mb-3">
                            <label for="content" class="form-label">
                                <i class="bi bi-file-text me-1"></i>
                                Conteúdo *
                            </label>
                            <div class="editor-toolbar mb-2">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatText('bold')">
                                        <i class="bi bi-type-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="formatText('italic')">
                                        <i class="bi bi-type-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertLink()">
                                        <i class="bi bi-link"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertCode()">
                                        <i class="bi bi-code"></i>
                                    </button>
                                </div>
                            </div>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="8"
                                      placeholder="Descreva sua dúvida ou compartilhe seu conhecimento..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Anexos -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label">
                                <i class="bi bi-paperclip me-1"></i>
                                Anexos (opcional)
                            </label>
                            <input type="file" 
                                   class="form-control" 
                                   id="attachments" 
                                   name="attachments[]" 
                                   multiple
                                   accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt">
                            <div class="form-text">
                                Formatos aceitos: JPG, PNG, GIF, PDF, DOC, DOCX, TXT. Máximo 5MB por arquivo.
                            </div>
                        </div>

                        <!-- Dicas -->
                        <div class="alert alert-info">
                            <h6><i class="bi bi-lightbulb me-1"></i> Dicas para um bom tópico:</h6>
                            <ul class="mb-0 small">
                                <li>Use um título claro e específico</li>
                                <li>Descreva o problema ou dúvida detalhadamente</li>
                                <li>Inclua exemplos de código quando relevante</li>
                                <li>Seja respeitoso e construtivo</li>
                            </ul>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('student.forum.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Publicar Tópico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres do título
    const titleInput = document.getElementById('title');
    const titleCounter = document.getElementById('titleCounter');
    
    titleInput.addEventListener('input', function() {
        titleCounter.textContent = this.value.length;
    });
    
    // Atualizar contador inicial
    titleCounter.textContent = titleInput.value.length;
});

// Funções de formatação de texto
function formatText(command) {
    const textarea = document.getElementById('content');
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

function insertLink() {
    const url = prompt('Digite a URL:');
    const text = prompt('Digite o texto do link:') || url;
    
    if (url) {
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        const linkText = `[${text}](${url})`;
        
        textarea.value = textarea.value.substring(0, start) + linkText + textarea.value.substring(textarea.selectionEnd);
        textarea.focus();
        textarea.setSelectionRange(start + linkText.length, start + linkText.length);
    }
}

function insertCode() {
    const textarea = document.getElementById('content');
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