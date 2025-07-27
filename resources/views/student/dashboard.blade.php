@extends('student.layouts.dashboard')

@section('title', 'Dashboard - Portal de Cursos')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Olá, {{ auth()->user()->name ?? 'Estudante' }}! 👋</h2>
                <p class="text-muted mb-0">Bem-vindo de volta ao seu painel de estudos</p>
            </div>
            <div class="d-none d-md-block">
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="bi bi-calendar-event me-2"></i>
                    {{ date('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-book text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">{{ $enrolledCourses ?? 5 }}</h3>
                        <p class="text-muted mb-0">Cursos Matriculados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">{{ $completedCourses ?? 2 }}</h3>
                        <p class="text-muted mb-0">Cursos Concluídos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-award text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">{{ $certificates ?? 2 }}</h3>
                        <p class="text-muted mb-0">Certificados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">{{ $studyHours ?? 48 }}h</h3>
                        <p class="text-muted mb-0">Horas de Estudo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Current Courses -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Cursos em Andamento</h5>
                    <a href="{{ route('student.courses') }}" class="btn btn-outline-primary btn-sm">
                        Ver Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                @php
                    $currentCourses = [
                        [
                            'title' => 'Desenvolvimento Web com Laravel',
                            'progress' => 75,
                            'nextLesson' => 'Autenticação e Autorização',
                            'instructor' => 'Prof. João Silva',
                            'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp'
                        ],
                        [
                            'title' => 'JavaScript Avançado',
                            'progress' => 45,
                            'nextLesson' => 'Promises e Async/Await',
                            'instructor' => 'Prof. Maria Santos',
                            'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp'
                        ],
                        [
                            'title' => 'Design UI/UX',
                            'progress' => 30,
                            'nextLesson' => 'Prototipagem no Figma',
                            'instructor' => 'Prof. Ana Costa',
                            'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp'
                        ]
                    ];
                @endphp

                @foreach($currentCourses as $course)
                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                    <img src="{{ $course['image'] }}" alt="{{ $course['title'] }}" class="rounded me-3" width="60" height="60">
                    <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">{{ $course['title'] }}</h6>
                        <p class="text-muted small mb-2">{{ $course['instructor'] }}</p>
                        <div class="d-flex align-items-center">
                            <div class="course-progress flex-grow-1 me-3">
                                <div class="progress-bar" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                            <span class="small text-muted">{{ $course['progress'] }}%</span>
                        </div>
                        <small class="text-primary">
                            <i class="bi bi-play-circle me-1"></i>
                            Próxima: {{ $course['nextLesson'] }}
                        </small>
                    </div>
                    <div class="ms-3">
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-play-fill"></i>
                        </button>
                    </div>
                </div>
                @endforeach
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
                <p class="text-muted mb-3">Sequência de Estudos</p>
                <div class="d-flex justify-content-center gap-1">
                    @for($i = 0; $i < 7; $i++)
                        <div class="bg-warning rounded-circle" style="width: 8px; height: 8px;"></div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h6 class="fw-bold mb-0">Ações Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('web.courses.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-search me-2"></i>Explorar Cursos
                    </a>
                    <a href="{{ route('student.certificates') }}" class="btn btn-outline-success">
                        <i class="bi bi-download me-2"></i>Baixar Certificados
                    </a>
                    <a href="{{ route('student.profile') }}" class="btn btn-outline-info">
                        <i class="bi bi-person-gear me-2"></i>Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-6 mb-4">
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
                            'description' => 'Autenticação JWT - Laravel',
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
                            'icon' => 'bi-bookmark',
                            'color' => 'primary',
                            'title' => 'Curso iniciado',
                            'description' => 'Design UI/UX Completo',
                            'time' => '3 dias atrás'
                        ],
                        [
                            'icon' => 'bi-chat-dots',
                            'color' => 'info',
                            'title' => 'Comentário no fórum',
                            'description' => 'Dúvida sobre React Hooks',
                            'time' => '5 dias atrás'
                        ]
                    ];
                @endphp

                @foreach($activities as $activity)
                <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
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
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0">Próximas Aulas</h5>
            </div>
            <div class="card-body">
                @php
                    $upcomingLessons = [
                        [
                            'course' => 'Laravel Avançado',
                            'lesson' => 'Middleware Personalizado',
                            'date' => 'Hoje',
                            'time' => '14:00',
                            'duration' => '45 min'
                        ],
                        [
                            'course' => 'JavaScript ES6+',
                            'lesson' => 'Destructuring e Spread',
                            'date' => 'Amanhã',
                            'time' => '10:00',
                            'duration' => '30 min'
                        ],
                        [
                            'course' => 'Design UI/UX',
                            'lesson' => 'Wireframes e Mockups',
                            'date' => 'Sexta',
                            'time' => '16:00',
                            'duration' => '60 min'
                        ]
                    ];
                @endphp

                @foreach($upcomingLessons as $lesson)
                <div class="d-flex align-items-center justify-content-between mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                    <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">{{ $lesson['lesson'] }}</h6>
                        <p class="text-muted small mb-1">{{ $lesson['course'] }}</p>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $lesson['date'] }} às {{ $lesson['time'] }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-clock me-1"></i>
                            {{ $lesson['duration'] }}
                        </div>
                    </div>
                    <div class="ms-3">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-bell"></i>
                        </button>
                    </div>
                </div>
                @endforeach

                <div class="text-center mt-3">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="bi bi-calendar-plus me-2"></i>Ver Agenda Completa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
