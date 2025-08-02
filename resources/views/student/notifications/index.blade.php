@extends('student.layouts.dashboard')

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-bell text-primary me-2"></i>
                    Minhas Notificações
                </h2>
                <p class="text-muted mb-0">Acompanhe todas as novidades dos seus cursos</p>
            </div>
            
            @if($notifications->where('read_at', null)->count() > 0)
                <div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="markAllAsReadBtn">
                        <i class="bi bi-check-all me-1"></i>
                        Marcar todas como lidas
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stats-card border-0 bg-primary bg-opacity-10">
            <div class="card-body text-center">
                <i class="bi bi-bell-fill text-primary fs-1 mb-2"></i>
                <h4 class="fw-bold text-primary mb-1">{{ $notifications->total() }}</h4>
                <small class="text-muted">Total de Notificações</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card border-0 bg-warning bg-opacity-10">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-circle-fill text-warning fs-1 mb-2"></i>
                <h4 class="fw-bold text-warning mb-1">{{ $notifications->where('read_at', null)->count() }}</h4>
                <small class="text-muted">Não Lidas</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card border-0 bg-success bg-opacity-10">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                <h4 class="fw-bold text-success mb-1">{{ $notifications->where('read_at', '!=', null)->count() }}</h4>
                <small class="text-muted">Lidas</small>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="row">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Lista de Notificações
                    </h5>
                    
                    @if($notifications->where('read_at', null)->count() > 0)
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleSelectAllBtn">
                                <i class="bi bi-check-square me-1"></i>
                                Selecionar Todas
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" disabled id="markSelectedBtn">
                                <i class="bi bi-check-all me-1"></i>
                                Marcar Selecionadas
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <form id="notificationsForm">
                    @csrf
                    @forelse ($notifications as $notification)
                        <div class="notification-item p-3 mb-3 rounded-3 border {{ $notification->read_at ? 'bg-light' : 'bg-light bg-opacity-5 border-primary border-opacity-25' }}">
                            <div class="d-flex align-items-start">
                                <!-- Checkbox para seleção -->
                                @if(!$notification->read_at)
                                    <div class="form-check me-3 mt-1">
                                        <input class="form-check-input notification-checkbox" type="checkbox" 
                                               value="{{ $notification->id }}" id="notification_{{ $notification->id }}">
                                    </div>
                                @else
                                    <div class="me-3" style="width: 20px;"></div>
                                @endif
                                
                                <div class="notification-icon me-3">
                                    @if(!$notification->read_at)
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-bell-fill text-white"></i>
                                        </div>
                                    @else
                                        <div class="bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-check-circle text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="notification-content flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0 {{ $notification->read_at ? 'text-muted' : 'fw-bold' }}">
                                            @if(str_contains($notification->data['message'], 'lição'))
                                                <i class="bi bi-play-circle me-1 text-info"></i>
                                            @elseif(str_contains($notification->data['message'], 'módulo'))
                                                <i class="bi bi-collection me-1 text-success"></i>
                                            @else
                                                <i class="bi bi-info-circle me-1 text-primary"></i>
                                            @endif
                                            Nova Atualização
                                        </h6>
                                        
                                        <div class="d-flex gap-2 align-items-center">
                                            @if(!$notification->read_at)
                                                <span class="badge bg-primary rounded-pill">Nova</span>
                                                <button type="button" class="btn btn-sm btn-outline-success mark-as-read-btn" 
                                                        data-notification-id="{{ $notification->id }}"
                                                        title="Marcar como lida">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">Lida</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <p class="mb-2 {{ $notification->read_at ? 'text-muted' : '' }}">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                        
                                        @if(isset($notification->data['url']) && $notification->data['url'] !== '#')
                                            <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-arrow-right me-1"></i>
                                                @if(str_contains($notification->data['message'], 'lição'))
                                                    Assistir Lição
                                                @elseif(str_contains($notification->data['message'], 'certificado'))
                                                    Ver Certificado
                                                @elseif(str_contains($notification->data['message'], 'módulo'))
                                                    Ver Módulo
                                                @elseif(str_contains($notification->data['message'], 'curso'))
                                                    Ver Curso
                                                @else
                                                    Ver Detalhes
                                                @endif
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-bell-slash text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-muted mb-2">Nenhuma notificação encontrada</h5>
                            <p class="text-muted">Quando houver novidades nos seus cursos, você será notificado aqui!</p>
                            <a href="{{ route('student.courses') }}" class="btn btn-primary">
                                <i class="bi bi-book me-2"></i>
                                Ver Meus Cursos
                            </a>
                        </div>
                    @endforelse
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Pagination condicional original -->
@if($notifications->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
// Aguardar o DOM carregar
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar eventos aos checkboxes
    document.querySelectorAll('.notification-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', updateMarkSelectedButton);
    });
    
    // Adicionar eventos aos botões de marcar como lida
    document.querySelectorAll('.mark-as-read-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            markAsRead(notificationId);
        });
    });
    
    // Evento para marcar todas como lidas
    const markAllBtn = document.getElementById('markAllAsReadBtn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', markAllAsRead);
    }
    
    // Evento para selecionar todas
    const toggleBtn = document.getElementById('toggleSelectAllBtn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSelectAll);
    }
    
    // Evento para marcar selecionadas
    const markSelectedBtn = document.getElementById('markSelectedBtn');
    if (markSelectedBtn) {
        markSelectedBtn.addEventListener('click', markSelectedAsRead);
    }
});

// Marcar notificação individual como lida
function markAsRead(notificationId) {
    fetch(`/student/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao marcar notificação como lida');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao marcar notificação como lida');
    });
}

// Marcar todas as notificações como lidas
function markAllAsRead() {
    if (confirm('Deseja marcar todas as notificações como lidas?')) {
        fetch('/student/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao marcar todas as notificações como lidas');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao marcar todas as notificações como lidas');
        });
    }
}

// Selecionar/deselecionar todas as notificações
function toggleSelectAll() {
    const checkboxes = document.querySelectorAll('.notification-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
    
    updateMarkSelectedButton();
    
    const btn = document.getElementById('toggleSelectAllBtn');
    btn.innerHTML = allChecked ? 
        '<i class="bi bi-check-square me-1"></i>Selecionar Todas' : 
        '<i class="bi bi-square me-1"></i>Desmarcar Todas';
}

// Atualizar estado do botão "Marcar Selecionadas"
function updateMarkSelectedButton() {
    const checkboxes = document.querySelectorAll('.notification-checkbox:checked');
    const btn = document.getElementById('markSelectedBtn');
    
    if (btn) {
        if (checkboxes.length > 0) {
            btn.disabled = false;
            btn.innerHTML = `<i class="bi bi-check-all me-1"></i>Marcar ${checkboxes.length} Selecionada${checkboxes.length > 1 ? 's' : ''}`;
        } else {
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-check-all me-1"></i>Marcar Selecionadas';
        }
    }
}

// Marcar notificações selecionadas como lidas
function markSelectedAsRead() {
    const checkboxes = document.querySelectorAll('.notification-checkbox:checked');
    const notificationIds = Array.from(checkboxes).map(cb => cb.value);
    
    if (notificationIds.length === 0) {
        alert('Selecione pelo menos uma notificação');
        return;
    }
    
    fetch('/student/notifications/mark-selected-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            notification_ids: notificationIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao marcar notificações como lidas');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao marcar notificações como lidas');
    });
}
</script>
@endsection
