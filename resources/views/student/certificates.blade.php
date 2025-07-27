@extends('student.layouts.dashboard')

@section('title', 'Certificados - Portal de Cursos')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Meus Certificados</h2>
                <p class="text-muted mb-0">Baixe e compartilhe seus certificados de conclusão</p>
            </div>
            <div>
                <button class="btn btn-outline-primary" onclick="shareAllCertificates()">
                    <i class="bi bi-share me-2"></i>Compartilhar Todos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-award text-warning" style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalCertificates ?? 2 }}</h3>
                <p class="text-muted mb-0">Certificados Emitidos</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-download text-primary" style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalDownloads ?? 8 }}</h3>
                <p class="text-muted mb-0">Downloads Realizados</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-share text-success" style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalShares ?? 3 }}</h3>
                <p class="text-muted mb-0">Compartilhamentos</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-clock text-info" style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalHours ?? 45 }}h</h3>
                <p class="text-muted mb-0">Horas Certificadas</p>
            </div>
        </div>
    </div>
</div>

<!-- Certificates Grid -->
<div class="row">
    @php
        $certificates = [
            [
                'id' => 1,
                'course' => 'Fundamentos do JavaScript',
                'instructor' => 'Prof. Carlos Lima',
                'completedAt' => '2024-01-15',
                'duration' => '20 horas',
                'grade' => 95,
                'certificateNumber' => 'JS-2024-001',
                'skills' => ['JavaScript', 'ES6+', 'DOM', 'Eventos'],
                'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                'verified' => true
            ],
            [
                'id' => 2,
                'course' => 'HTML e CSS Responsivo',
                'instructor' => 'Prof. Lucia Ferreira',
                'completedAt' => '2024-01-08',
                'duration' => '25 horas',
                'grade' => 88,
                'certificateNumber' => 'HTML-2024-002',
                'skills' => ['HTML5', 'CSS3', 'Flexbox', 'Grid', 'Responsivo'],
                'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                'verified' => true
            ]
        ];
    @endphp

    @foreach($certificates as $certificate)
    <div class="col-lg-6 mb-4">
        <div class="card stats-card h-100">
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="position-relative h-100">
                        <img src="{{ $certificate['image'] }}" class="img-fluid rounded-start h-100" alt="Certificado" style="object-fit: cover; min-height: 200px;">
                        @if($certificate['verified'])
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success">
                                    <i class="bi bi-patch-check-fill me-1"></i>Verificado
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body h-100 d-flex flex-column">
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-2">{{ $certificate['course'] }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-person me-1"></i>{{ $certificate['instructor'] }}
                            </p>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Concluído em</small>
                                    <strong>{{ date('d/m/Y', strtotime($certificate['completedAt'])) }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Duração</small>
                                    <strong>{{ $certificate['duration'] }}</strong>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Nota Final</small>
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">{{ $certificate['grade'] }}%</strong>
                                        @if($certificate['grade'] >= 90)
                                            <span class="badge bg-success">Excelente</span>
                                        @elseif($certificate['grade'] >= 80)
                                            <span class="badge bg-primary">Muito Bom</span>
                                        @else
                                            <span class="badge bg-warning">Bom</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Nº Certificado</small>
                                    <strong class="small">{{ $certificate['certificateNumber'] }}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Competências Adquiridas</small>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($certificate['skills'] as $skill)
                                        <span class="badge bg-light text-dark">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <button class="btn btn-primary btn-sm flex-fill" onclick="downloadCertificate({{ $certificate['id'] }})">
                                <i class="bi bi-download me-1"></i>Download
                            </button>
                            <button class="btn btn-outline-primary btn-sm flex-fill" onclick="viewCertificate({{ $certificate['id'] }})">
                                <i class="bi bi-eye me-1"></i>Visualizar
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="shareCertificate({{ $certificate['id'] }})">
                                        <i class="bi bi-share me-2"></i>Compartilhar
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="verifyCertificate('{{ $certificate['certificateNumber'] }}')">
                                        <i class="bi bi-patch-check me-2"></i>Verificar Autenticidade
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="addToLinkedIn({{ $certificate['id'] }})">
                                        <i class="bi bi-linkedin me-2"></i>Adicionar ao LinkedIn
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Empty State (if no certificates) -->
@if(empty($certificates))
<div class="row">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-award text-muted" style="font-size: 5rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Nenhum certificado ainda</h4>
                <p class="text-muted mb-4">Complete seus cursos para receber certificados de conclusão</p>
                <a href="{{ route('student.courses') }}" class="btn btn-primary">
                    <i class="bi bi-book me-2"></i>Ver Meus Cursos
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Certificate Verification Info -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-2">
                            <i class="bi bi-shield-check text-success me-2"></i>
                            Certificados Verificáveis
                        </h5>
                        <p class="text-muted mb-0">
                            Todos os nossos certificados são verificáveis online através do número do certificado.
                            Empregadores e instituições podem confirmar a autenticidade dos seus certificados.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#verificationModal">
                            <i class="bi bi-search me-2"></i>Verificar Certificado
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-patch-check me-2"></i>Verificar Certificado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <div class="mb-3">
                        <label for="certificateNumber" class="form-label">Número do Certificado</label>
                        <input type="text" class="form-control" id="certificateNumber" placeholder="Ex: JS-2024-001">
                        <div class="form-text">Digite o número do certificado para verificar sua autenticidade</div>
                    </div>
                    <div id="verificationResult" class="d-none">
                        <!-- Result will be shown here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="performVerification()">Verificar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function downloadCertificate(certificateId) {
    // Simulate certificate download
    const link = document.createElement('a');
    link.href = `/student/certificates/${certificateId}/download`;
    link.download = `certificado-${certificateId}.pdf`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // Show success message
    showToast('Certificado baixado com sucesso!', 'success');
}

function viewCertificate(certificateId) {
    // Open certificate in new window
    window.open(`/student/certificates/${certificateId}/view`, '_blank');
}

function shareCertificate(certificateId) {
    if (navigator.share) {
        navigator.share({
            title: 'Meu Certificado - Portal de Cursos',
            text: 'Confira meu certificado de conclusão!',
            url: `${window.location.origin}/certificates/verify/${certificateId}`
        });
    } else {
        // Fallback: copy to clipboard
        const url = `${window.location.origin}/certificates/verify/${certificateId}`;
        navigator.clipboard.writeText(url).then(() => {
            showToast('Link copiado para a área de transferência!', 'success');
        });
    }
}

function shareAllCertificates() {
    const profileUrl = `${window.location.origin}/student/profile/public`;
    if (navigator.share) {
        navigator.share({
            title: 'Meus Certificados - Portal de Cursos',
            text: 'Confira todos os meus certificados!',
            url: profileUrl
        });
    } else {
        navigator.clipboard.writeText(profileUrl).then(() => {
            showToast('Link do perfil copiado para a área de transferência!', 'success');
        });
    }
}

function verifyCertificate(certificateNumber) {
    document.getElementById('certificateNumber').value = certificateNumber;
    const modal = new bootstrap.Modal(document.getElementById('verificationModal'));
    modal.show();
}

function addToLinkedIn(certificateId) {
    const linkedInUrl = `https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name=Certificado%20Portal%20de%20Cursos&organizationName=Portal%20de%20Cursos&issueYear=2024&issueMonth=1&certUrl=${encodeURIComponent(window.location.origin + '/certificates/verify/' + certificateId)}`;
    window.open(linkedInUrl, '_blank');
}

function performVerification() {
    const certificateNumber = document.getElementById('certificateNumber').value;
    const resultDiv = document.getElementById('verificationResult');

    if (!certificateNumber) {
        showToast('Por favor, digite o número do certificado', 'warning');
        return;
    }

    // Simulate verification process
    resultDiv.innerHTML = `
        <div class="alert alert-info">
            <i class="bi bi-hourglass-split me-2"></i>Verificando certificado...
        </div>
    `;
    resultDiv.classList.remove('d-none');

    setTimeout(() => {
        // Simulate successful verification
        resultDiv.innerHTML = `
            <div class="alert alert-success">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Certificado Verificado!</strong>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted d-block">Curso</small>
                        <strong>Fundamentos do JavaScript</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Estudante</small>
                        <strong>João da Silva</strong>
                    </div>
                    <div class="col-6 mt-2">
                        <small class="text-muted d-block">Data de Conclusão</small>
                        <strong>15/01/2024</strong>
                    </div>
                    <div class="col-6 mt-2">
                        <small class="text-muted d-block">Carga Horária</small>
                        <strong>20 horas</strong>
                    </div>
                </div>
            </div>
        `;
    }, 2000);
}

function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(toast);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}
</script>
@endsection
