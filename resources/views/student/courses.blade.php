@extends('student.layouts.dashboard')

@section('title', 'Meus Cursos - Portal de Cursos')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Meus Cursos</h2>
                <p class="text-muted mb-0">Gerencie seus cursos e acompanhe seu progresso</p>
            </div>
            <div>
                <a href="{{ route('web.courses') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Explorar Cursos
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card stats-card">
            <div class="card-body">
                <ul class="nav nav-pills" id="courseFilter" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                            <i class="bi bi-grid me-2"></i>Todos (5)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="progress-tab" data-bs-toggle="pill" data-bs-target="#progress" type="button" role="tab">
                            <i class="bi bi-play-circle me-2"></i>Em Andamento (3)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                            <i class="bi bi-check-circle me-2"></i>Concluídos (2)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="favorites-tab" data-bs-toggle="pill" data-bs-target="#favorites" type="button" role="tab">
                            <i class="bi bi-heart me-2"></i>Favoritos (1)
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Course Content -->
<div class="tab-content" id="courseFilterContent">
    <!-- All Courses -->
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="row">
            @php
                $allCourses = [
                    [
                        'id' => 1,
                        'title' => 'Desenvolvimento Web com Laravel',
                        'instructor' => 'Prof. João Silva',
                        'progress' => 75,
                        'status' => 'progress',
                        'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                        'duration' => '40 horas',
                        'lessons' => 25,
                        'completedLessons' => 19,
                        'lastAccessed' => '2 horas atrás',
                        'nextLesson' => 'Autenticação e Autorização',
                        'certificate' => false
                    ],
                    [
                        'id' => 2,
                        'title' => 'JavaScript Avançado',
                        'instructor' => 'Prof. Maria Santos',
                        'progress' => 45,
                        'status' => 'progress',
                        'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                        'duration' => '30 horas',
                        'lessons' => 20,
                        'completedLessons' => 9,
                        'lastAccessed' => '1 dia atrás',
                        'nextLesson' => 'Promises e Async/Await',
                        'certificate' => false
                    ],
                    [
                        'id' => 3,
                        'title' => 'Design UI/UX Completo',
                        'instructor' => 'Prof. Ana Costa',
                        'progress' => 30,
                        'status' => 'progress',
                        'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                        'duration' => '35 horas',
                        'lessons' => 18,
                        'completedLessons' => 5,
                        'lastAccessed' => '3 dias atrás',
                        'nextLesson' => 'Prototipagem no Figma',
                        'certificate' => false
                    ],
                    [
                        'id' => 4,
                        'title' => 'Fundamentos do JavaScript',
                        'instructor' => 'Prof. Carlos Lima',
                        'progress' => 100,
                        'status' => 'completed',
                        'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                        'duration' => '20 horas',
                        'lessons' => 15,
                        'completedLessons' => 15,
                        'lastAccessed' => '1 semana atrás',
                        'nextLesson' => null,
                        'certificate' => true
                    ],
                    [
                        'id' => 5,
                        'title' => 'HTML e CSS Responsivo',
                        'instructor' => 'Prof. Lucia Ferreira',
                        'progress' => 100,
                        'status' => 'completed',
                        'image' => env('APP_URL') . '/web/img/webp/no-image-available-1by1.webp',
                        'duration' => '25 horas',
                        'lessons' => 12,
                        'completedLessons' => 12,
                        'lastAccessed' => '2 semanas atrás',
                        'nextLesson' => null,
                        'certificate' => true
                    ]
                ];
            @endphp

            @foreach($allCourses as $course)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card stats-card h-100">
                    <div class="position-relative">
                        <img src="{{ $course['image'] }}" class="card-img-top" alt="{{ $course['title'] }}" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($course['status'] === 'completed')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Concluído
                                </span>
                            @else
                                <span class="badge bg-primary">
                                    <i class="bi bi-play-circle me-1"></i>Em Andamento
                                </span>
                            @endif
                        </div>
                        @if($course['certificate'])
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning">
                                    <i class="bi bi-award me-1"></i>Certificado
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">{{ $course['title'] }}</h5>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-person me-1"></i>{{ $course['instructor'] }}
                        </p>

                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progresso</small>
                                <small class="fw-semibold">{{ $course['progress'] }}%</small>
                            </div>
                            <div class="course-progress">
                                <div class="progress-bar" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <small class="text-muted d-block">Aulas</small>
                                <strong>{{ $course['completedLessons'] }}/{{ $course['lessons'] }}</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Duração</small>
                                <strong>{{ $course['duration'] }}</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Último acesso</small>
                                <strong class="small">{{ $course['lastAccessed'] }}</strong>
                            </div>
                        </div>

                        @if($course['nextLesson'])
                            <div class="alert alert-primary alert-sm mb-3">
                                <small>
                                    <i class="bi bi-play-circle me-1"></i>
                                    <strong>Próxima:</strong> {{ $course['nextLesson'] }}
                                </small>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex gap-2">
                            @if($course['status'] === 'completed')
                                <button class="btn btn-outline-primary flex-fill">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Revisar
                                </button>
                                @if($course['certificate'])
                                    <button class="btn btn-success flex-fill">
                                        <i class="bi bi-download me-1"></i>Certificado
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-primary flex-fill">
                                    <i class="bi bi-play-fill me-1"></i>Continuar
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="bi bi-heart"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- In Progress Courses -->
    <div class="tab-pane fade" id="progress" role="tabpanel">
        <div class="row">
            @foreach(array_filter($allCourses, function($course) { return $course['status'] === 'progress'; }) as $course)
            <div class="col-lg-6 col-xl-4 mb-4">
                <!-- Same card structure as above -->
                <div class="card stats-card h-100">
                    <div class="position-relative">
                        <img src="{{ $course['image'] }}" class="card-img-top" alt="{{ $course['title'] }}" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-primary">
                                <i class="bi bi-play-circle me-1"></i>Em Andamento
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">{{ $course['title'] }}</h5>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-person me-1"></i>{{ $course['instructor'] }}
                        </p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progresso</small>
                                <small class="fw-semibold">{{ $course['progress'] }}%</small>
                            </div>
                            <div class="course-progress">
                                <div class="progress-bar" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                        </div>

                        <div class="alert alert-primary alert-sm mb-3">
                            <small>
                                <i class="bi bi-play-circle me-1"></i>
                                <strong>Próxima:</strong> {{ $course['nextLesson'] }}
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary flex-fill">
                                <i class="bi bi-play-fill me-1"></i>Continuar
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Completed Courses -->
    <div class="tab-pane fade" id="completed" role="tabpanel">
        <div class="row">
            @foreach(array_filter($allCourses, function($course) { return $course['status'] === 'completed'; }) as $course)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card stats-card h-100">
                    <div class="position-relative">
                        <img src="{{ $course['image'] }}" class="card-img-top" alt="{{ $course['title'] }}" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Concluído
                            </span>
                        </div>
                        @if($course['certificate'])
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning">
                                    <i class="bi bi-award me-1"></i>Certificado
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">{{ $course['title'] }}</h5>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-person me-1"></i>{{ $course['instructor'] }}
                        </p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progresso</small>
                                <small class="fw-semibold text-success">{{ $course['progress'] }}%</small>
                            </div>
                            <div class="course-progress">
                                <div class="progress-bar bg-success" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                        </div>

                        <div class="alert alert-success alert-sm mb-3">
                            <small>
                                <i class="bi bi-check-circle me-1"></i>
                                <strong>Curso concluído!</strong> Parabéns!
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary flex-fill">
                                <i class="bi bi-arrow-clockwise me-1"></i>Revisar
                            </button>
                            @if($course['certificate'])
                                <button class="btn btn-success flex-fill">
                                    <i class="bi bi-download me-1"></i>Certificado
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Favorites -->
    <div class="tab-pane fade" id="favorites" role="tabpanel">
        <div class="row">
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card stats-card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('web/img/webp/no-image-available-1by1.webp') }}" class="card-img-top" alt="Laravel" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-primary">
                                <i class="bi bi-play-circle me-1"></i>Em Andamento
                            </span>
                        </div>
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">
                                <i class="bi bi-heart-fill me-1"></i>Favorito
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">Desenvolvimento Web com Laravel</h5>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-person me-1"></i>Prof. João Silva
                        </p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progresso</small>
                                <small class="fw-semibold">75%</small>
                            </div>
                            <div class="course-progress">
                                <div class="progress-bar" style="width: 75%"></div>
                            </div>
                        </div>

                        <div class="alert alert-primary alert-sm mb-3">
                            <small>
                                <i class="bi bi-play-circle me-1"></i>
                                <strong>Próxima:</strong> Autenticação e Autorização
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary flex-fill">
                                <i class="bi bi-play-fill me-1"></i>Continuar
                            </button>
                            <button class="btn btn-danger">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
