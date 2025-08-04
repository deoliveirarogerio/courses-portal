@extends('student.layouts.dashboard')

@section('title', $room->name . ' - Chat')

@section('content')
<div class="container-fluid h-100">
    <div class="row h-100">
        <!-- Chat Principal -->
        <div class="col-md-8">
            <div class="card h-100 d-flex flex-column">
                <!-- Cabeçalho da Sala -->
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('student.chat.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                            <div>
                                <h5 class="mb-0">{{ $room->name }}</h5>
                                <small class="text-muted">
                                    @if($room->type === 'course' && $room->course)
                                        <i class="bi bi-book me-1"></i>{{ $room->course->title }}
                                    @else
                                        <i class="bi bi-people me-1"></i>{{ $room->participants->count() }} participantes
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <button class="btn btn-sm btn-outline-danger" onclick="leaveRoom()">
                                <i class="bi bi-box-arrow-right me-1"></i>Sair
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Área de Mensagens -->
                <div class="card-body flex-grow-1 p-0 d-flex flex-column">
                    <div id="messages-container" class="flex-grow-1 overflow-auto p-3">
                        <div id="messages-list">
                            @foreach($messages->reverse() as $message)
                                <div class="message-item mb-3" data-message-id="{{ $message->id }}">
                                    <div class="d-flex {{ $message->user_id === auth()->id() ? 'justify-content-end' : '' }}">
                                        <div class="message-bubble {{ $message->user_id === auth()->id() ? 'message-own' : 'message-other' }}">
                                            @if($message->user_id !== auth()->id())
                                                <div class="message-header mb-1">
                                                    <small class="fw-bold text-primary">{{ $message->user->name }}</small>
                                                    @if($message->user->type === 'instrutor')
                                                        <span class="badge bg-warning ms-1">Instrutor</span>
                                                    @endif
                                                    <small class="text-muted ms-2">{{ $message->created_at->format('H:i') }}</small>
                                                </div>
                                            @endif
                                            
                                            @if($message->replyTo)
                                                <div class="reply-reference mb-2 p-2 bg-light rounded">
                                                    <small class="text-muted">
                                                        <i class="bi bi-reply me-1"></i>
                                                        <strong>{{ $message->replyTo->user->name }}:</strong>
                                                        {{ Str::limit($message->replyTo->message, 50) }}
                                                    </small>
                                                </div>
                                            @endif
                                            
                                            <div class="message-content">
                                                @if($message->type === 'image')
                                                    <div class="message-image mb-2">
                                                        <img src="{{ Storage::url($message->metadata['path']) }}" 
                                                             class="img-fluid rounded" 
                                                             style="max-width: 300px; max-height: 200px;"
                                                             onclick="showImageModal(this.src)">
                                                    </div>
                                                @elseif($message->type === 'file')
                                                    <div class="message-file mb-2">
                                                        <a href="{{ Storage::url($message->metadata['path']) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-file-earmark me-1"></i>
                                                            {{ $message->metadata['original_name'] }}
                                                        </a>
                                                    </div>
                                                @endif
                                                
                                                <div class="message-text">
                                                    {!! $message->formatted_message !!}
                                                </div>
                                            </div>
                                            
                                            @if($message->user_id === auth()->id())
                                                <div class="message-time text-end mt-1">
                                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                                </div>
                                            @endif
                                            
                                            <div class="message-actions mt-1">
                                                <button class="btn btn-sm btn-link p-0 me-2" onclick="replyToMessage({{ $message->id }}, '{{ $message->user->name }}', '{{ addslashes($message->message) }}')">
                                                    <i class="bi bi-reply"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Indicador de digitação -->
                        <div id="typing-indicator" class="typing-indicator" style="display: none;">
                            <div class="typing-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <small class="text-muted ms-2">Alguém está digitando...</small>
                        </div>
                    </div>

                    <!-- Área de resposta (quando há reply) -->
                    <div id="reply-area" class="reply-area p-2 bg-light border-top" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="bi bi-reply me-1"></i>
                                    Respondendo a <strong id="reply-user"></strong>
                                </small>
                                <div id="reply-content" class="text-muted small"></div>
                            </div>
                            <button class="btn btn-sm btn-link" onclick="cancelReply()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Formulário de Mensagem -->
                    <div class="card-footer">
                        <form id="message-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="reply_to" name="reply_to">
                            
                            <div class="input-group">
                                <input type="file" 
                                       id="attachment" 
                                       name="attachment" 
                                       class="d-none"
                                       accept="image/*,.pdf,.doc,.docx"
                                       onchange="showAttachmentPreview()">
                                
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('attachment').click()">
                                    <i class="bi bi-paperclip"></i>
                                </button>
                                
                                <input type="text" 
                                       id="message-input" 
                                       name="message" 
                                       class="form-control" 
                                       placeholder="Digite sua mensagem..."
                                       autocomplete="off"
                                       maxlength="1000">
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                            
                            <!-- Preview do anexo -->
                            <div id="attachment-preview" class="mt-2" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark me-2"></i>
                                        <span id="attachment-name"></span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link" onclick="removeAttachment()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Participantes -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-people me-2"></i>
                        Participantes ({{ $room->participants->count() }})
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="participants-list">
                        @foreach($room->participants as $participant)
                            <div class="participant-item p-3 border-bottom d-flex align-items-center">
                                <div class="participant-avatar me-3">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold">
                                            {{ substr($participant->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    @if($participant->isOnline())
                                        <div class="online-indicator"></div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $participant->user->name }}</h6>
                                    <small class="text-muted">
                                        @if($participant->user->type === 'instrutor')
                                            <i class="bi bi-mortarboard text-warning me-1"></i>Instrutor
                                        @else
                                            <i class="bi bi-person text-primary me-1"></i>Aluno
                                        @endif
                                        @if($participant->isOnline())
                                            • <span class="text-success">Online</span>
                                        @else
                                            • {{ $participant->last_seen_at ? $participant->last_seen_at->diffForHumans() : 'Nunca visto' }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar imagens -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modal-image" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
.message-bubble {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 18px;
    word-wrap: break-word;
}

.message-own {
    background-color: #007bff;
    color: white;
    margin-left: auto;
}

.message-other {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
}

.message-actions {
    opacity: 0;
    transition: opacity 0.2s;
}

.message-item:hover .message-actions {
    opacity: 1;
}

.participant-item {
    position: relative;
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background-color: #28a745;
    border: 2px solid white;
    border-radius: 50%;
}

.typing-indicator {
    display: flex;
    align-items: center;
    padding: 10px;
}

.typing-dots {
    display: flex;
    gap: 4px;
}

.typing-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #6c757d;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

.chat-link {
    color: #007bff;
    text-decoration: none;
}

.mention {
    background-color: #e3f2fd;
    color: #1976d2;
    padding: 2px 4px;
    border-radius: 4px;
    font-weight: 500;
}

#messages-container {
    height: 400px;
}
</style>

<script>
const roomId = {{ $room->id }};
const userId = {{ auth()->id() }};
let replyToId = null;

// Configurar Echo para tempo real
window.Echo.join(`chat-room.${roomId}`)
    .here((users) => {
        console.log('Usuários online:', users);
    })
    .joining((user) => {
        console.log('Usuário entrou:', user);
        addSystemMessage(`${user.name} entrou na sala`);
    })
    .leaving((user) => {
        console.log('Usuário saiu:', user);
        addSystemMessage(`${user.name} saiu da sala`);
    })
    .listen('MessageSent', (e) => {
        if (e.message.user.id !== userId) {
            addMessage(e.message);
            scrollToBottom();
        }
    });

// Enviar mensagem
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    const attachment = document.getElementById('attachment').files[0];
    
    if (!message && !attachment) return;
    
    const formData = new FormData();
    formData.append('message', message);
    formData.append('reply_to', replyToId);
    if (attachment) {
        formData.append('attachment', attachment);
    }
    
    console.log('Enviando mensagem:', {
        message,
        roomId,
        replyToId
    });
    
    fetch(`{{ route('student.chat.send', $room->id) }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => {
        console.log('Status da resposta:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Erro no servidor:', text);
                throw new Error(text);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Resposta do servidor:', data);
        if (data.success) {
            messageInput.value = '';
            removeAttachment();
            cancelReply();
            addMessage(data.message);
            scrollToBottom();
        } else {
            console.error('Erro:', data.error);
            alert(data.error || 'Erro ao enviar mensagem');
        }
    })
    .catch(error => {
        console.error('Erro ao enviar mensagem:', error);
        alert('Erro ao enviar mensagem: ' + error.message);
    });
});

function addMessage(message) {
    const messagesList = document.getElementById('messages-list');
    const messageHtml = createMessageHtml(message);
    messagesList.insertAdjacentHTML('beforeend', messageHtml);
}

function addSystemMessage(text) {
    const messagesList = document.getElementById('messages-list');
    const systemMessageHtml = `
        <div class="text-center my-2">
            <small class="text-muted bg-light px-2 py-1 rounded">${text}</small>
        </div>
    `;
    messagesList.insertAdjacentHTML('beforeend', systemMessageHtml);
}

function createMessageHtml(message) {
    const isOwn = message.user.id === userId;
    const time = new Date(message.created_at).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
    
    return `
        <div class="message-item mb-3" data-message-id="${message.id}">
            <div class="d-flex ${isOwn ? 'justify-content-end' : ''}">
                <div class="message-bubble ${isOwn ? 'message-own' : 'message-other'}">
                    ${!isOwn ? `
                        <div class="message-header mb-1">
                            <small class="fw-bold text-primary">${message.user.name}</small>
                            ${message.user.type === 'instrutor' ? '<span class="badge bg-warning ms-1">Instrutor</span>' : ''}
                            <small class="text-muted ms-2">${time}</small>
                        </div>
                    ` : ''}
                    
                    ${message.reply_to ? `
                        <div class="reply-reference mb-2 p-2 bg-light rounded">
                            <small class="text-muted">
                                <i class="bi bi-reply me-1"></i>
                                <strong>${message.reply_to.user.name}:</strong>
                                ${message.reply_to.message.substring(0, 50)}${message.reply_to.message.length > 50 ? '...' : ''}
                            </small>
                        </div>
                    ` : ''}
                    
                    <div class="message-content">
                        <div class="message-text">${message.message}</div>
                    </div>
                    
                    ${isOwn ? `
                        <div class="message-time text-end mt-1">
                            <small class="text-muted">${time}</small>
                        </div>
                    ` : ''}
                    
                    <div class="message-actions mt-1">
                        <button class="btn btn-sm btn-link p-0 me-2" onclick="replyToMessage(${message.id}, '${message.user.name}', '${message.message.replace(/'/g, "\\'")}')">
                            <i class="bi bi-reply"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function replyToMessage(messageId, userName, messageText) {
    replyToId = messageId;
    document.getElementById('reply_to').value = messageId;
    document.getElementById('reply-user').textContent = userName;
    document.getElementById('reply-content').textContent = messageText.substring(0, 100) + (messageText.length > 100 ? '...' : '');
    document.getElementById('reply-area').style.display = 'block';
    document.getElementById('message-input').focus();
}

function cancelReply() {
    replyToId = null;
    document.getElementById('reply_to').value = '';
    document.getElementById('reply-area').style.display = 'none';
}

function showAttachmentPreview() {
    const file = document.getElementById('attachment').files[0];
    if (file) {
        document.getElementById('attachment-name').textContent = file.name;
        document.getElementById('attachment-preview').style.display = 'block';
    }
}

function removeAttachment() {
    document.getElementById('attachment').value = '';
    document.getElementById('attachment-preview').style.display = 'none';
}

function showImageModal(src) {
    document.getElementById('modal-image').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

function leaveRoom() {
    if (confirm('Tem certeza que deseja sair desta sala?')) {
        fetch(`{{ route('student.chat.leave', $room->id) }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(() => {
            window.location.href = '{{ route('student.chat.index') }}';
        });
    }
}

// Atualizar última visualização periodicamente
setInterval(() => {
    fetch(`{{ route('student.chat.updateLastSeen', $room->id) }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    });
}, 30000);

// Scroll inicial para o final
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
});
</script>
@endsection