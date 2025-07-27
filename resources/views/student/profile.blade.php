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

<!-- Alerts -->
<div id="alertContainer"></div>

<!-- Profile Overview -->
<div class="row mb-4">
    <div class="col-lg-4 mb-4">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-3">
                    <div class="user-avatar mx-auto" style="width: 120px; height: 120px; font-size: 3rem; background-image: url('{{ $student->avatar_url }}'); background-size: cover; background-position: center;">
                        @if(!$student->avatar)
                            {{ substr($user->name ?? 'U', 0, 1) }}
                        @endif
                    </div>
                    <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle"
                            style="width: 35px; height: 35px;" data-bs-toggle="modal" data-bs-target="#avatarModal">
                        <i class="bi bi-camera"></i>
                    </button>
                </div>
                <h4 class="fw-bold mb-1">{{ $user->name ?? 'Nome do Usuário' }}</h4>
                <p class="text-muted mb-3">{{ $user->email ?? 'email@exemplo.com' }}</p>

                <div class="row text-center mb-3">
                    <div class="col-4">
                        <h5 class="fw-bold mb-0">{{ $enrolledCourses ?? 0 }}</h5>
                        <small class="text-muted">Cursos</small>
                    </div>
                    <div class="col-4">
                        <h5 class="fw-bold mb-0">{{ $certificates ?? 0 }}</h5>
                        <small class="text-muted">Certificados</small>
                    </div>
                    <div class="col-4">
                        <h5 class="fw-bold mb-0">{{ $studyHours ?? 0 }}h</h5>
                        <small class="text-muted">Estudadas</small>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="bi bi-star me-1"></i>{{ $student->experience_level_label ?? 'Nível Iniciante' }}
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
                        <p class="fw-semibold mb-0">{{ $user->name ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">E-mail</label>
                        <p class="fw-semibold mb-0">{{ $user->email ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Telefone</label>
                        <p class="fw-semibold mb-0">{{ $student->phone ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Data de Nascimento</label>
                        <p class="fw-semibold mb-0">{{ $student->birth_date_formatted ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Cidade</label>
                        <p class="fw-semibold mb-0">{{ $student->city ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Profissão</label>
                        <p class="fw-semibold mb-0">{{ $student->profession ?? 'Não informado' }}</p>
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
                            @if($student->interests && count($student->interests) > 0)
                                @foreach($student->interests as $interest)
                                    <span class="badge bg-primary">{{ $interest }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Nenhum interesse definido</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Nível de Experiência</label>
                        <p class="fw-semibold mb-0">{{ $student->experience_level_label ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Horário Preferido</label>
                        <p class="fw-semibold mb-0">{{ $student->preferred_time_label ?? 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small">Meta Semanal</label>
                        <p class="fw-semibold mb-0">{{ $student->weekly_goal_hours ?? 20 }} horas de estudo</p>
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
                        <form id="notificationsForm">
                            @csrf
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications"
                                       {{ $student->email_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">
                                    Notificações por e-mail
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="course_reminders" name="course_reminders"
                                       {{ $student->course_reminders ? 'checked' : '' }}>
                                <label class="form-check-label" for="course_reminders">
                                    Lembretes de aulas
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="progress_updates" name="progress_updates"
                                       {{ $student->progress_updates ? 'checked' : '' }}>
                                <label class="form-check-label" for="progress_updates">
                                    Atualizações de progresso
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="marketing_emails" name="marketing_emails"
                                       {{ $student->marketing_emails ? 'checked' : '' }}>
                                <label class="form-check-label" for="marketing_emails">
                                    E-mails promocionais
                                </label>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <h6 class="fw-semibold mb-3">Privacidade</h6>
                        <form id="privacyForm">
                            @csrf
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="public_profile" name="public_profile"
                                       {{ $student->public_profile ? 'checked' : '' }}>
                                <label class="form-check-label" for="public_profile">
                                    Perfil público
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="show_progress" name="show_progress"
                                       {{ $student->show_progress ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_progress">
                                    Mostrar progresso nos cursos
                                </label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="show_certificates" name="show_certificates"
                                       {{ $student->show_certificates ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_certificates">
                                    Mostrar certificados
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="allow_messages" name="allow_messages"
                                       {{ $student->allow_messages ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_messages">
                                    Permitir mensagens de outros alunos
                                </label>
                            </div>
                        </form>
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
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $student->phone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date"
                                   value="{{ $student->birth_date ? $student->birth_date->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $student->city }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ $student->state }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="profession" class="form-label">Profissão</label>
                            <input type="text" class="form-control" id="profession" name="profession" value="{{ $student->profession }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="experience_level" class="form-label">Nível de Experiência</label>
                            <select class="form-select" id="experience_level" name="experience_level">
                                <option value="iniciante" {{ $student->experience_level == 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                                <option value="intermediario" {{ $student->experience_level == 'intermediario' ? 'selected' : '' }}>Intermediário</option>
                                <option value="avancado" {{ $student->experience_level == 'avancado' ? 'selected' : '' }}>Avançado</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="preferred_time" class="form-label">Horário Preferido</label>
                            <select class="form-select" id="preferred_time" name="preferred_time">
                                <option value="manha" {{ $student->preferred_time == 'manha' ? 'selected' : '' }}>Manhã (6h - 12h)</option>
                                <option value="tarde" {{ $student->preferred_time == 'tarde' ? 'selected' : '' }}>Tarde (12h - 18h)</option>
                                <option value="noite" {{ $student->preferred_time == 'noite' ? 'selected' : '' }}>Noite (18h - 22h)</option>
                                <option value="madrugada" {{ $student->preferred_time == 'madrugada' ? 'selected' : '' }}>Madrugada (0h - 6h)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="weekly_goal_hours" class="form-label">Meta Semanal (horas)</label>
                            <input type="number" class="form-control" id="weekly_goal_hours" name="weekly_goal_hours"
                                   value="{{ $student->weekly_goal_hours }}" min="1" max="168">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="bio" class="form-label">Biografia</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Conte um pouco sobre você...">{{ $student->bio }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="interests" class="form-label">Áreas de Interesse</label>
                            <div class="row">
                                @php
                                    $availableInterests = [
                                        'Desenvolvimento Web', 'JavaScript', 'Laravel', 'UI/UX Design',
                                        'Mobile', 'Python', 'Marketing Digital', 'Design Gráfico',
                                        'Data Science', 'Inteligência Artificial'
                                    ];
                                    $userInterests = $student->interests ?? [];
                                @endphp
                                @foreach($availableInterests as $interest)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="interests[]"
                                                   value="{{ $interest }}" id="interest_{{ $loop->index }}"
                                                   {{ in_array($interest, $userInterests) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="interest_{{ $loop->index }}">
                                                {{ $interest }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-camera me-2"></i>Alterar Avatar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="avatarForm" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center mb-3">
                        <div class="user-avatar mx-auto" style="width: 120px; height: 120px; font-size: 3rem; background-image: url('{{ $student->avatar_url }}'); background-size: cover; background-position: center;">
                            @if(!$student->avatar)
                                {{ substr($user->name ?? 'U', 0, 1) }}
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Escolher Nova Foto</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" required>
                        <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="uploadAvatar()">Upload Avatar</button>
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
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
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
                        <input type="text" class="form-control" id="profileUrl" value="https://portal.com/profile/{{ $user->id }}" readonly>
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
// Função para salvar perfil
function saveProfile() {
    const formData = new FormData(document.getElementById('editProfileForm'));

    fetch('{{ route("student.profile.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
            modal.hide();
            showAlert('Perfil atualizado com sucesso!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('Erro ao atualizar perfil. Verifique os dados informados.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Erro ao atualizar perfil.', 'danger');
    });
}

// Função para upload de avatar
function uploadAvatar() {
    const formData = new FormData(document.getElementById('avatarForm'));

    fetch('{{ route("student.profile.avatar") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('avatarModal'));
            modal.hide();
            showAlert('Avatar atualizado com sucesso!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert(data.message || 'Erro ao fazer upload do avatar.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Erro ao fazer upload do avatar.', 'danger');
    });
}

// Função para alterar senha
function changePassword() {
    const formData = new FormData(document.getElementById('changePasswordForm'));

    fetch('{{ route("student.profile.change-password") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
            modal.hide();
            showAlert('Senha alterada com sucesso!', 'success');
            document.getElementById('changePasswordForm').reset();
        } else {
            showAlert(data.message || 'Erro ao alterar senha.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Erro ao alterar senha.', 'danger');
    });
}

// Função para mostrar alertas
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    alertContainer.appendChild(alert);

    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 5000);
}

// Salvar configurações automaticamente
document.querySelectorAll('#notificationsForm .form-check-input').forEach(input => {
    input.addEventListener('change', function() {
        const formData = new FormData(document.getElementById('notificationsForm'));

        fetch('{{ route("student.profile.notifications") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Configuração de notificação salva!', 'success');
            }
        });
    });
});

document.querySelectorAll('#privacyForm .form-check-input').forEach(input => {
    input.addEventListener('change', function() {
        const formData = new FormData(document.getElementById('privacyForm'));

        fetch('{{ route("student.profile.privacy") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Configuração de privacidade salva!', 'success');
            }
        });
    });
});

// Funções de compartilhamento
function copyProfileUrl() {
    const profileUrl = document.getElementById('profileUrl');
    profileUrl.select();
    document.execCommand('copy');
    showAlert('Link copiado para a área de transferência!', 'success');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent('https://portal.com/profile/{{ $user->id }}');
    const text = encodeURIComponent('Confira meu perfil no Portal de Cursos!');
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}&title=${text}`, '_blank');
}

function shareOnTwitter() {
    const url = encodeURIComponent('https://portal.com/profile/{{ $user->id }}');
    const text = encodeURIComponent('Confira meu perfil no Portal de Cursos!');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
}

function shareOnWhatsApp() {
    const text = encodeURIComponent('Confira meu perfil no Portal de Cursos: https://portal.com/profile/{{ $user->id }}');
    window.open(`https://wa.me/?text=${text}`, '_blank');
}
</script>
@endsection
