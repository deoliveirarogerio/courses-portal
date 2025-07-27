@extends('student.layouts.dashboard')

@section('title', 'Meu Perfil - Portal de Cursos')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Meu Perfil</h2>
                <p class="text-muted mb-0">Gerencie suas informações pessoais e preferências</p>
            </div>
            <div>
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#shareProfileModal">
                    <i class="bi bi-share me-2"></i>Compartilhar Perfil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Overview -->
<div class="row mb-4">
    <div class="col-lg-4 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-3">
                    <div class="user-avatar mx-auto" style="width: 120px; height: 120px; font-size: 3rem;">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle" 
                            style="width: 35px; height: 35px;" data-bs-toggle="modal" data-bs-target="#avatarModal">
                        <i class="bi bi-camera"></i>
                    </button>
                </div>
                <h4 class="fw-bold mb-1">{{ auth()->user()->name ?? 'Nome do Usuário' }}</h4>
                <p class="text-muted mb-3">{{ auth()->user()->email ?? 'email@exemplo.com' }}</p>
                
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <h5 class="fw-bold mb-0">{{ $enrolledCourses ?? 5 }}</h5>
                        <small class="text-muted">Cursos</small>
                    </div>
                    <div class="col-4">
                        <h5 class="fw-bold mb-0">{{ $certificates ?? 2 }}</h5>
                        <small class="text-muted">Certificados</small>
                    </div>
                    <div class="col-4">
                        <h5 class="fw-bold mb-0">{{ $studyHours ?? 48 }}h</h5>
                        <small class="text-muted">Estudadas</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="bi bi-star me-1"></i>Nível Intermediário
                    </span>
                </div>
                
                <div class="d-grid">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil me-2"></i>Editar Perfil
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="card stats-card mb-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Informações Pessoais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Nome Completo</label>
                        <p class="fw-semibold mb-0">{{ auth()->user()->name ?? 'João da Silva Santos' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">E-mail</label>
                        <p class="fw-semibold mb-0">{{ auth()->user()->email ?? 'joao@exemplo.com' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Telefone</label>
                        <p class="fw-semibold mb-0">{{ $phone ?? '(11) 99999-9999' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Data de Nascimento</label>
                        <p class="fw-semibold mb-0">{{ $birthDate ?? '15/03/1990' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Cidade</label>
                        <p class="fw-semibold mb-0">{{ $city ?? 'São Paulo, SP' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Profissão</label>
                        <p class="fw-semibold mb-0">{{ $profession ?? 'Desenvolvedor Web' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Learning Preferences -->
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Preferências de Aprendizado</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Áreas de Interesse</label>
                        <div class="d-flex flex-wrap gap-1">
                            @php
                                $interests = ['Desenvolvimento Web', 'JavaScript', 'Laravel', 'UI/UX Design', 'Mobile'];
                            @endphp
                            @foreach($interests as $interest)
                                <span class="badge bg-primary">{{ $interest }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Nível de Experiência</label>
                        <p class="fw-semibold mb-0">Intermediário</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Horário Preferido</label>
                        <p class="fw-semibold mb-0">Noite (18h - 22h)</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Meta Semanal</label>
                        <p class="fw-semibold mb-0">20 horas de estudo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Account Settings -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Configurações da Conta</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h6 class="fw-semibold mb-3">Notificações</h6>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                            <label class="form-check-label" for="emailNotifications">
                                Notificações por e-mail
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="courseReminders" checked>
                            <label class="form-check-label" for="courseReminders">
                                Lembretes de aulas
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="progressUpdates">
                            <label class="form-check-label" for="progressUpdates">
                                Atualizações de progresso
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="marketingEmails">
                            <label class="form-check-label" for="marketingEmails">
                                E-mails promocionais
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <h6 class="fw-semibold mb-3">Privacidade</h6>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="publicProfile" checked>
                            <label class="form-check-label" for="publicProfile">
                                Perfil público
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="showProgress" checked>
                            <label class="form-check-label" for="showProgress">
                                Mostrar progresso nos cursos
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="showCertificates">
                            <label class="form-check-label" for="showCertificates">
                                Mostrar certificados
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="allowMessages">
                            <label class="form-check-label" for="allowMessages">
                                Permitir mensagens de outros alunos
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <hr>
                        <h6 class="fw-semibold mb-3 text-danger">Zona de Perigo</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key me-2"></i>Alterar Senha
                            </button>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                <i class="bi bi-trash me-2"></i>Excluir Conta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Atividade Recente</h5>
            </div>
            <div class="card-body">
                @php
                    $activities = [
                        [
                            'icon' => 'bi-check-circle',
                            'color' => 'success',
                            'title' => 'Aula concluída',
                            'description' => 'Autenticação JWT - Laravel Avançado',
                            'time' => '2 horas atrás'
                        ],
                        [
                            'icon' => 'bi-award',
                            'color' => 'warning',
                            'title' => 'Certificado emitido',
                            'description' => 'Fundamentos do JavaScript',
                            'time' => '1 dia atrás'
                        ],
                        [
                            'icon' => 'bi-person-gear',
                            'color' => 'info',
                            'title' => 'Perfil atualizado',
                            'description' => 'Informações pessoais alteradas',
                            'time' => '3 dias atrás'
                        ],
                        [
                            'icon' => 'bi-bookmark',
                            'color' => 'primary',
                            'title' => 'Curso iniciado',
                            'description' => 'Design UI/UX Completo',
                            'time' => '5 dias atrás'
                        ]
                    ];
                @endphp
                
                <div class="row">
                    @foreach($activities as $activity)
                    <div class="col-lg-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-{{ $activity['color'] }} bg-opacity-10 rounded-circle p-2">
                                    <i class="bi {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-semibold mb-1">{{ $activity['title'] }}</h6>
                                <p class="text-muted small mb-1">{{ $activity['description'] }}</p>
                                <small class="text-muted">{{ $activity['time'] }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Editar Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editName" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="editName" value="{{ auth()->user()->name ?? 'João da Silva Santos' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="editEmail" value="{{ auth()->user()->email ?? 'joao@exemplo.com' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editPhone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="editPhone" value="(11) 99999-9999">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editBirthDate" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="editBirthDate" value="1990-03-15">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editCity" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="editCity" value="São Paulo, SP">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editProfession" class="form-label">Profissão</label>
                            <input type="text" class="form-control" id="editProfession" value="Desenvolvedor Web">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="editBio" class="form-label">Biografia</label>
                            <textarea class="form-control" id="editBio" rows="3" placeholder="Conte um pouco sobre você..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveProfile()">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-key me-2"></i>Alterar Senha
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="changePassword()">Alterar Senha</button>
            </div>
        </div>
    </div>
</div>

<!-- Share Profile Modal -->
<div class="modal fade" id="shareProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-share me-2"></i>Compartilhar Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Compartilhe seu perfil público e conquistas com outros</p>
                <div class="mb-3">
                    <label for="profileUrl" class="form-label">Link do Perfil</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="profileUrl" value="https://portal.com/profile/joao-silva" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyProfileUrl()">
                            <i class="bi bi-copy"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill" onclick="shareOnLinkedIn()">
                        <i class="bi bi-linkedin me-2"></i>LinkedIn
                    </button>
                    <button class="btn btn-info flex-fill" onclick="shareOnTwitter()">
                        <i class="bi bi-twitter me-2"></i>Twitter
                    </button>
                    <button class="btn btn-success flex-fill" onclick="shareOnWhatsApp()">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function saveProfile() {
    // Simulate saving profile
    const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
    modal.hide();
    showToast('Perfil atualizado com sucesso!', 'success');
}

function changePassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        showToast('Preencha todos os campos', 'warning');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showToast('As senhas não coincidem', 'danger');
        return;
    }
    
    // Simulate password change
    const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
    modal.hide();
    showToast('Senha alterada com sucesso!', 'success');
}

function copyProfileUrl() {
    const profileUrl = document.getElementById('profileUrl');
    profileUrl.select();
    document.execCommand('copy');
    showToast('Link copiado para a área de transferência!', 'success');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent('https://portal.com/profile/joao-silva');
    const text = encodeURIComponent('Confira meu perfil no Portal de Cursos!');
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}&title=${text}`, '_blank');
}

function shareOnTwitter() {
    const url = encodeURIComponent('https://portal.com/profile/joao-silva');
    const text = encodeURIComponent('Confira meu perfil no Portal de Cursos!');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
}

function shareOnWhatsApp() {
    const text = encodeURIComponent('Confira meu perfil no Portal de Cursos: https://portal.com/profile/joao-silva');
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}

// Save settings automatically
document.querySelectorAll('.form-check-input').forEach(input => {
    input.addEventListener('change', function() {
        showToast('Configuração salva automaticamente', 'info');
    });
});
</script>
@endsection