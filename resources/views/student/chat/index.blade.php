@extends('student.layouts.dashboard')

@section('title', 'Chat - Portal de Cursos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="bi bi-chat-dots me-2"></i>Chat
                    </h2>
                    <p class="text-muted mb-0">Converse com outros alunos e instrutores</p>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                        <i class="bi bi-plus-circle me-2"></i>Criar Sala
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Minhas Salas -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-dots me-2"></i>
                        Minhas Salas ({{ $myRooms->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($myRooms as $room)
                        <div class="chat-room-item p-3 border-bottom" onclick="enterRoom({{ $room->id }})">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <h6 class="mb-0 me-2">{{ $room->name }}</h6>
                                        @if($room->type === 'course')
                                            <span class="badge bg-primary">
                                                <i class="bi bi-book me-1"></i>Curso
                                            </span>
                                        @elseif($room->type === 'public')
                                            <span class="badge bg-success">
                                                <i class="bi bi-globe me-1"></i>Público
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-lock me-1"></i>Privado
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($room->latestMessage)
                                        <p class="text-muted mb-1 small">
                                            <strong>{{ $room->latestMessage->user->name }}:</strong>
                                            {{ Str::limit($room->latestMessage->message, 50) }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $room->latestMessage->created_at->diffForHumans() }}
                                        </small>
                                    @else
                                        <p class="text-muted mb-0 small">Nenhuma mensagem ainda</p>
                                    @endif
                                </div>
                                <div class="chat-room-info text-end">
                                    <div class="participants-count mb-1">
                                        <i class="bi bi-people me-1"></i>
                                        <small>{{ $room->participants->count() }}</small>
                                    </div>
                                    @php
                                        $unreadCount = $room->unreadMessagesCount(auth()->id());
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-chat-left-dots fs-1 text-muted"></i>
                            <h6 class="text-muted mt-3">Você ainda não participa de nenhuma sala</h6>
                            <p class="text-muted">Entre em uma sala pública ou de curso para começar a conversar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Salas Públicas -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-globe me-2"></i>
                        Salas Públicas ({{ $publicRooms->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($publicRooms as $room)
                        <div class="chat-room-item p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $room->name }}</h6>
                                    @if($room->description)
                                        <p class="text-muted mb-2 small">{{ $room->description }}</p>
                                    @endif
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-people me-1"></i>
                                        <small class="text-muted">{{ $room->participants->count() }} participantes</small>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary" onclick="joinRoom({{ $room->id }})">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-globe fs-1 text-muted"></i>
                            <h6 class="text-muted mt-3">Nenhuma sala pública disponível</h6>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Salas de Cursos -->
    @if($courseRooms->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-book me-2"></i>
                            Salas de Cursos Disponíveis ({{ $courseRooms->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="row g-0">
                            @foreach($courseRooms as $room)
                                <div class="col-md-6">
                                    <div class="chat-room-item p-3 border-bottom border-end">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $room->name }}</h6>
                                                <p class="text-muted mb-2 small">
                                                    <i class="bi bi-book me-1"></i>{{ $room->course->title }}
                                                </p>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-people me-1"></i>
                                                    <small class="text-muted">{{ $room->participants->count() }} participantes</small>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary" onclick="joinRoom({{ $room->id }})">
                                                    <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal Criar Sala -->
<div class="modal fade" id="createRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Nova Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('student.chat.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="room_name" class="form-label">Nome da Sala *</label>
                        <input type="text" class="form-control" id="room_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="room_description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="room_description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="room_type" class="form-label">Tipo da Sala *</label>
                        <select class="form-select" id="room_type" name="type" required>
                            <option value="public">Pública - Qualquer pessoa pode entrar</option>
                            <option value="private">Privada - Apenas convidados</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_participants" class="form-label">Máximo de Participantes</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" min="2" max="100">
                        <small class="text-muted">Deixe em branco para ilimitado</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Sala</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
.chat-room-item {
    cursor: pointer;
    transition: background-color 0.2s;
}

.chat-room-item:hover {
    background-color: #f8f9fa;
}

.participants-count {
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endsection

@section('scripts')
<script>
function enterRoom(roomId) {
    window.location.href = `{{ route('student.chat.room', '') }}/${roomId}`;
}

function joinRoom(roomId) {
    console.log('Tentando entrar na sala:', roomId);
    
    fetch(`{{ route('student.chat.join', '') }}/${roomId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Se não for JSON, mostrar o HTML de erro
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Resposta de erro (HTML):', text);
                throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}...`);
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            window.location.reload();
        } else {
            console.error('Erro do servidor:', data.error);
            alert(data.error || 'Erro ao entrar na sala');
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert('Erro ao entrar na sala: ' + error.message);
    });
}
</script>
@endsection


