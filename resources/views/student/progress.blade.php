@extends('student.layouts.dashboard')

@section('title', 'Progresso - Portal de Cursos')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Meu Progresso</h2>
                <p class="text-muted mb-0">Acompanhe seu desenvolvimento e estatísticas de aprendizado</p>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar me-2"></i>Últimos 30 dias
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Últimos 7 dias</a></li>
                        <li><a class="dropdown-item" href="#">Últimos 30 dias</a></li>
                        <li><a class="dropdown-item" href="#">Últimos 3 meses</a></li>
                        <li><a class="dropdown-item" href="#">Este ano</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overall Progress -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-3">Progresso Geral</h4>
                        <div class="row">
                            <div class="col-sm-3 mb-3">
                                <div class="text-center">
                                    <div class="position-relative d-inline-block">
                                        <svg width="80" height="80" class="progress-ring">
                                            <circle cx="40" cy="40" r="35" stroke="#e9ecef" stroke-width="6" fill="transparent"></circle>
                                            <circle cx="40" cy="40" r="35" stroke="#667eea" stroke-width="6" fill="transparent"
                                                    stroke-dasharray="220" stroke-dashoffset="66" class="progress-ring-circle"></circle>
                                        </svg>
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <strong class="fs-6">70%</strong>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">Conclusão Geral</small>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <h5 class="fw-bold mb-1">{{ $totalLessons ?? 87 }}</h5>
                                        <small class="text-muted">Aulas Assistidas</small>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h5 class="fw-bold mb-1">{{ $studyHours ?? 48 }}h</h5>
                                        <small class="text-muted">Horas de Estudo</small>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="fw-bold mb-1">{{ $streak ?? 7 }}</h5>
                                        <small class="text-muted">Dias Consecutivos</small>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="fw-bold mb-1">{{ $avgScore ?? 92 }}%</h5>
                                        <small class="text-muted">Nota Média</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-trophy text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-1">Nível Intermediário</h5>
                        <p class="text-muted small mb-3">1.250 XP de 2.000 XP</p>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 62.5%"></div>
                        </div>
                        <small class="text-muted">750 XP para o próximo nível</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Study Activity Chart -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Atividade de Estudos</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <canvas id="studyChart" height="300"></canvas>
                </div>
                <div class="row text-center">
                    <div class="col-3">
                        <div class="border-end">
                            <h6 class="fw-bold mb-1">2.5h</h6>
                            <small class="text-muted">Média Diária</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border-end">
                            <h6 class="fw-bold mb-1">18h</h6>
                            <small class="text-muted">Esta Semana</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border-end">
                            <h6 class="fw-bold mb-1">5</h6>
                            <small class="text-muted">Dias Ativos</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <h6 class="fw-bold mb-1">92%</h6>
                        <small class="text-muted">Meta Semanal</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <!-- Study Streak -->
        <div class="card stats-card mb-3">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-fire text-warning" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-1">7 Dias</h4>
                <p class="text-muted mb-3">Sequência Atual</p>
                <div class="d-flex justify-content-center gap-1 mb-3">
                    @for($i = 0; $i < 7; $i++)
                        <div class="bg-warning rounded-circle" style="width: 12px; height: 12px;"></div>
                    @endfor
                </div>
                <small class="text-muted">Melhor sequência: 12 dias</small>
            </div>
        </div>

        <!-- Weekly Goal -->
        <div class="card stats-card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Meta Semanal</h6>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Horas de Estudo</span>
                    <span class="fw-bold">18h / 20h</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 90%"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Aulas Concluídas</span>
                    <span class="fw-bold">12 / 15</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: 80%"></div>
                </div>
                <div class="text-center">
                    <small class="text-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Você está indo muito bem!
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Progress -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Progresso por Curso</h5>
            </div>
            <div class="card-body">
                @php
                    $courseProgress = [
                        [
                            'title' => 'Desenvolvimento Web com Laravel',
                            'progress' => 75,
                            'completedLessons' => 19,
                            'totalLessons' => 25,
                            'timeSpent' => '28h',
                            'lastActivity' => '2 horas atrás',
                            'color' => 'primary'
                        ],
                        [
                            'title' => 'JavaScript Avançado',
                            'progress' => 45,
                            'completedLessons' => 9,
                            'totalLessons' => 20,
                            'timeSpent' => '12h',
                            'lastActivity' => '1 dia atrás',
                            'color' => 'info'
                        ],
                        [
                            'title' => 'Design UI/UX Completo',
                            'progress' => 30,
                            'completedLessons' => 5,
                            'totalLessons' => 18,
                            'timeSpent' => '8h',
                            'lastActivity' => '3 dias atrás',
                            'color' => 'warning'
                        ],
                        [
                            'title' => 'Fundamentos do JavaScript',
                            'progress' => 100,
                            'completedLessons' => 15,
                            'totalLessons' => 15,
                            'timeSpent' => '20h',
                            'lastActivity' => '1 semana atrás',
                            'color' => 'success'
                        ]
                    ];
                @endphp

                @foreach($courseProgress as $course)
                <div class="row align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                    <div class="col-md-4">
                        <h6 class="fw-semibold mb-1">{{ $course['title'] }}</h6>
                        <small class="text-muted">{{ $course['completedLessons'] }}/{{ $course['totalLessons'] }} aulas • {{ $course['timeSpent'] }}</small>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                <div class="progress-bar bg-{{ $course['color'] }}" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                            <span class="fw-semibold">{{ $course['progress'] }}%</span>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <small class="text-muted">{{ $course['lastActivity'] }}</small>
                    </div>
                    <div class="col-md-2 text-end">
                        @if($course['progress'] === 100)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Concluído
                            </span>
                        @else
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-play-fill"></i>
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Achievements -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Conquistas Recentes</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $achievements = [
                            [
                                'icon' => 'bi-award',
                                'title' => 'Primeiro Certificado',
                                'description' => 'Concluiu seu primeiro curso',
                                'date' => '15/01/2024',
                                'color' => 'warning',
                                'unlocked' => true
                            ],
                            [
                                'icon' => 'bi-fire',
                                'title' => 'Sequência de 7 Dias',
                                'description' => 'Estudou por 7 dias consecutivos',
                                'date' => 'Hoje',
                                'color' => 'danger',
                                'unlocked' => true
                            ],
                            [
                                'icon' => 'bi-clock',
                                'title' => 'Maratonista',
                                'description' => 'Completou 50 horas de estudo',
                                'date' => '10/01/2024',
                                'color' => 'info',
                                'unlocked' => true
                            ],
                            [
                                'icon' => 'bi-star',
                                'title' => 'Nota Máxima',
                                'description' => 'Obteve 100% em uma avaliação',
                                'date' => '08/01/2024',
                                'color' => 'success',
                                'unlocked' => true
                            ],
                            [
                                'icon' => 'bi-lightning',
                                'title' => 'Velocista',
                                'description' => 'Complete 5 aulas em um dia',
                                'date' => null,
                                'color' => 'secondary',
                                'unlocked' => false
                            ],
                            [
                                'icon' => 'bi-gem',
                                'title' => 'Colecionador',
                                'description' => 'Obtenha 5 certificados',
                                'date' => null,
                                'color' => 'secondary',
                                'unlocked' => false
                            ]
                        ];
                    @endphp

                    @foreach($achievements as $achievement)
                    <div class="col-lg-2 col-md-4 col-6 mb-3">
                        <div class="text-center p-3 rounded {{ $achievement['unlocked'] ? 'bg-light' : 'bg-light opacity-50' }}">
                            <div class="mb-2">
                                <i class="bi {{ $achievement['icon'] }} text-{{ $achievement['color'] }}" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-1 small">{{ $achievement['title'] }}</h6>
                            <p class="text-muted small mb-1">{{ $achievement['description'] }}</p>
                            @if($achievement['unlocked'])
                                <small class="text-success">
                                    <i class="bi bi-check-circle me-1"></i>{{ $achievement['date'] }}
                                </small>
                            @else
                                <small class="text-muted">
                                    <i class="bi bi-lock me-1"></i>Bloqueado
                                </small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Learning Analytics -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Horários de Estudo</h5>
            </div>
            <div class="card-body">
                <canvas id="timeChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Categorias de Cursos</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="200"></canvas>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <small>Desenvolvimento Web (60%)</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <small>JavaScript (25%)</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <small>Design (15%)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Study Activity Chart
    const studyCtx = document.getElementById('studyChart').getContext('2d');
    new Chart(studyCtx, {
        type: 'line',
        data: {
            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Horas de Estudo',
                data: [2, 3, 1, 4, 2, 1, 5],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 6
                }
            }
        }
    });

    // Time Chart
    const timeCtx = document.getElementById('timeChart').getContext('2d');
    new Chart(timeCtx, {
        type: 'bar',
        data: {
            labels: ['6h', '8h', '10h', '12h', '14h', '16h', '18h', '20h', '22h'],
            datasets: [{
                label: 'Atividade',
                data: [1, 2, 3, 2, 5, 8, 6, 4, 2],
                backgroundColor: '#764ba2'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Desenvolvimento Web', 'JavaScript', 'Design'],
            datasets: [{
                data: [60, 25, 15],
                backgroundColor: ['#667eea', '#17a2b8', '#ffc107']
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection
